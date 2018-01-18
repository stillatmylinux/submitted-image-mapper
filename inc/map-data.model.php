<?php

namespace SIM;

class MapData {
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
		$this->setImage();
		$this->setInfowindowContent($post, $postmeta);
	}

	public function getDate() {
		return date('M j, Y g:i a', strtotime($this->date));
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