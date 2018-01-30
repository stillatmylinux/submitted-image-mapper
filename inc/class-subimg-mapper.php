<?php

require_once('map-data.model.php');

use SIM\MapData;

class SubmittedImageMapper {

	public $mapData = array();
	public $google_api;

	public function hooks() {
		add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_shortcode( 'mapper-recent', array( $this, 'mapper_shortcode' ) );
		add_shortcode( 'mapper-archive', array( $this, 'mapper_shortcode_archive' ) );
	}

	public function enqueue_scripts() {

		$js_ver  = date("ymd-Gis", filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'js/sImgMap.js' ));
		$css_ver = date("ymd-Gis", filemtime( plugin_dir_path( dirname( __FILE__ ) ) . 'css/styles.css' ));
		 
		// 
		wp_enqueue_script( 'simgmap', plugins_url( 'js/sImgMap.js', dirname( __FILE__ ) ), array(), $js_ver );
		wp_register_style( 'simgstyle',    plugins_url( 'css/styles.css',    dirname( __FILE__ ) ), false,   $css_ver );
		wp_enqueue_style ( 'simgstyle' );

		$drop_marker_page_id = get_option('sim-drop-marker-page');
		$drop_marker_page_url = '';
		if( $drop_marker_page_id ) {
			$drop_marker_page_url = get_permalink($drop_marker_page_id);
		}

		$thankyou_page_id = get_option('sim-drop-marker-page');
		$thankyou_page_url = '';
		if( $thankyou_page_id ) {
			$thankyou_page_url = get_permalink($thankyou_page_id);
		}

		wp_localize_script( 'simgmap', 'simgmapUrls', array(
			'dropMarkerPage' => $drop_marker_page_url,
			'thankyouPage'   => $thankyou_page_url,
		) );
	}

	public function mapper_shortcode() {
		ob_start();
		simgmap_get_template_part('map', 'recent');
		return ob_get_clean();
	}

	public function mapper_shortcode_archive() {
		ob_start();
		simgmap_get_template_part('map', 'archive');
		return ob_get_clean();
	}

	public function getGoogleApi() {
		if(is_null($this->google_api)) {
			$this->google_api = get_option('sim-google-api');
		}

		return $this->google_api;
	}

	public function getPhotoList( $post_type = 'submitted-pic', $timeframe = array() ) {

		$query_args = array(
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order'   => 'ASC',
		);

		if(!empty($timeframe)) {
			$query_args['date_query'] = array(
				$timeframe
			);
		}

		$custom_query = new WP_Query( $query_args );

		if( $custom_query->have_posts() ) {
			while( $custom_query->have_posts() ) { $custom_query->the_post();

				$postmeta = get_post_meta(get_the_ID());

				if(isset($postmeta['lat'], $postmeta['lat'])) {
					array_push($this->mapData, new MapData($custom_query->post, $postmeta, $custom_query->post->post_date));
				}

			}
		}

		return $this->mapData;
	}
}