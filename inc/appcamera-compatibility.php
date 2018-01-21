<?php

class SIM_AppCamera_Compatibility {

	public function hooks() {
		add_action( 'appp_before_camera_buttons', array( $this, 'custom_appcamera_fields' ) );
		add_action( 'wp_insert_post', array( $this, 'custom_appcamera_upload_handler' ) );
		add_action( 'appp_after_process_uploads', array( $this, 'add_lat_longs' ), 10, 2 );
	}

	public function add_lat_longs( $post_id, $attachment_id ) {

		$filepath = get_attached_file($attachment_id);

		$location = get_image_location($filepath);

		if($location) {
			update_post_meta( $post_id, 'lat', $location['lat'] );
			update_post_meta( $post_id, 'lng', $location['lng'] );
			update_post_meta( $post_id, 'attachment_id', $attachment_id );
			wp_send_json_success(array(
				'location' => true,
				'lat' => $location['lat'],
				'lng' => $location['lng'],
				'post_id'  => $post_id,
				'attachment_id'  => $attachment_id
			));
		} else {
			wp_send_json_success(array(
				'location' => false,
				'post_id'  => $post_id,
				'attachment_id'  => $attachment_id
			));
		}
	}

	public function custom_appcamera_fields() {
		simgmap_get_template_part( 'extra-appcamera-fields' );
	}

	public function custom_appcamera_upload_handler( $post_id ) {

		$fields = array(
			'name',
			'location',
			'description'
		);

		//Check if we have $_POST data
		//$post_id comes from the wp_insert_post action. It will be the ID of the newly created post.
		if ( !empty( $_POST ) ) {
		   //We will need to do this for each field name attribute provided in the custom_appcamera_fields function.
		   foreach( $fields as $field ) {
			   if ( isset( $_POST[$field] ) ) {
				 //absint() just to be certain. Set meta key, as necessary, for each. Sanitize the posted value
				 update_post_meta( absint( $post_id ), $field, sanitize_text_field( $_POST[$field] ) );
			   }

		   }
		}
	}
}