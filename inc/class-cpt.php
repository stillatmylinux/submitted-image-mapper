<?php

class SIM_SubmittedPhoto_CPT {

	public function hooks() {
		add_action( 'init', array( $this, 'submitted_photo_post_type' ) );
	}

	public function submitted_photo_post_type() {

		$singular = 'Submitted Pic';
		$plural   = 'Submitted Pics';
		$s_short = 'Pic';
		$p_short = 'Pics';

		$labels = array(
			'name'                  => _x( $plural, $plural . ' General Name', 'simgmap' ),
			'singular_name'         => _x( $singular, $plural . ' Singular Name', 'simgmap' ),
			'menu_name'             => __( $plural, 'simgmap' ),
			'name_admin_bar'        => __( $plural, 'simgmap' ),
			'archives'              => __( $s_short . ' Archives', 'simgmap' ),
			'parent_item_colon'     => __( 'Parent '.$s_short.':', 'simgmap' ),
			'all_items'             => __( 'All '.$p_short, 'simgmap' ),
			'add_new_item'          => __( 'Add New '.$s_short, 'simgmap' ),
			'add_new'               => __( 'Add New', 'simgmap' ),
			'new_item'              => __( 'New '.$s_short, 'simgmap' ),
			'edit_item'             => __( 'Edit '.$s_short, 'simgmap' ),
			'update_item'           => __( 'Update '.$s_short, 'simgmap' ),
			'view_item'             => __( 'View '.$s_short, 'simgmap' ),
			'search_items'          => __( 'Search '.$s_short, 'simgmap' ),
			'not_found'             => __( 'Not found', 'simgmap' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'simgmap' ),
			'featured_image'        => __( 'Featured Image', 'simgmap' ),
			'set_featured_image'    => __( 'Set featured image', 'simgmap' ),
			'remove_featured_image' => __( 'Remove featured image', 'simgmap' ),
			'use_featured_image'    => __( 'Use as featured image', 'simgmap' ),
			'insert_into_item'      => __( 'Insert into item', 'simgmap' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'simgmap' ),
			'items_list'            => __( 'Logs list', 'simgmap' ),
			'items_list_navigation' => __( 'Logs list navigation', 'simgmap' ),
			'filter_items_list'     => __( 'Filter items list', 'simgmap' ),
		);
		$args = array(
			'label'                 => __( $singular, 'simgmap' ),
			'description'           => __( $plural, 'simgmap' ),
			'labels'                => $labels,
			'supports'              => array( ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( 'submitted-pic', $args );
	
	}
	
}