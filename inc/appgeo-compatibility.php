<?php

class SIM_AppGeo_Compatibility {

	public function hooks() {
		add_filter( 'wp_ajax_sim_post_location', array( $this, 'add_checkin_geolocation' ) );
		add_filter( 'wp_ajax_nopriv_sim_post_location', array( $this, 'add_checkin_geolocation' ) );
	}

	public function add_checkin_geolocation() {

		if(isset($_POST['post_id'], $_POST['lat'], $_POST['lng'])) {

			add_post_meta( (int)$_POST['post_id'], 'lat', $_POST['lat']);
			add_post_meta( (int)$_POST['post_id'], 'lng', $_POST['lng']);

			$_POST['attachment_id'] = get_post_meta( (int)$_POST['post_id'], 'attachment_id', true );

			wp_send_json_success($_POST);
		}
		
	}
}