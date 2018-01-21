<?php

namespace SIM;

class MapData {

	private $months_3 = (60 * 60 * 24 * 30 * 3);
	private $months_2 = (60 * 60 * 24 * 30 * 2);
	private $months_1 = (60 * 60 * 24 * 30);
	private $minutes_15 = (60 * 15);
	private $minutes_60 = (60 * 60);
	private $hours_3    = (60 * 60 * 3);

	private $post;
	private $postmeta;
	public $lat;
	public $lng;
	public $name;
	public $image;
	public $description;
	public $location;
	public $date;
	public $status;
	public $infowindowContent;
	public $color;

	public function __construct( $post, $postmeta, $date ) {
		$this->post = $post;
		$this->postmeta = $postmeta;
		$this->location = (isset($postmeta['location'])) ? $postmeta['location'][0] : '';
		$this->lat = (isset($postmeta['lat'])) ? $postmeta['lat'][0] : '';
		$this->lng = (isset($postmeta['lng'])) ? $postmeta['lng'][0] : '';
		$this->description = (isset($postmeta['description'])) ? $postmeta['description'][0] : '';
		$this->name = (isset($postmeta['name'])) ? $postmeta['name'][0] : '';
		$this->status = (isset($postmeta['status'])) ? $postmeta['status'][0] : 'publish';
		$this->date = $date;
		$this->setMarkerColor();
		$this->setImage();
		$this->setInfowindowContent($post, $postmeta);
	}

	public function getPost() {
		return $this->post;
	}

	public function getPostmeta() {
		return $this->postmeta;
	}

	public function getDate() {
		return date('M j, Y g:i a', strtotime($this->date));
	}

	public function setMarkerColor() {

		if(has_action('sim_set_marker_color')) {
			$this->color = apply_filters('sim_set_marker_color', $this);
		} else {
			$wordpress_timezone = get_option('timezone_string');
	
			$date = new \DateTime($this->date, new \DateTimeZone($wordpress_timezone));
			$now = new \DateTime(null, new \DateTimeZone($wordpress_timezone));
			
			$date = strtotime($date->format('Y-m-d H:i:s'));
			$now  = strtotime($now->format('Y-m-d H:i:s'));
	
			$diff = $now - $date;
	
			if($diff <= $this->minutes_15)
				$this->color = 'red';
			else if($diff <= $this->minutes_60)
				$this->color = 'orange';
			else if($diff <= $this->hours_3)
				$this->color = 'yellow';
			else if($diff <= $this->months_1)
				$this->color = 'green';
			else if($diff <= $this->months_2)
				$this->color = 'blue';
			else if($diff <= $this->months_3)
				$this->color = 'purple';
		}

	}

	private function setInfowindowContent($post, $postmeta) {
		$data = $this;
		ob_start();
		include simgmap_get_template_part( 'map', 'infowindow', false );
		$this->infowindowContent = ob_get_contents();
		ob_end_clean();
	}

	private function setImage() {
		$images = get_attached_media('image', $this->post->ID);

		foreach($images as $image) { 
			$this->image = wp_get_attachment_image_src($image->ID, 'full')[0];
			return;
		}
	}
}