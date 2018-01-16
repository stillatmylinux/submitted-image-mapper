<?php

namespace SIM;

class MapData {
	public $lat;
	public $lng;
	public $name;
	public $description;
	public $location;
	public $date;
	public $status;


	public function __construct( $postmeta, $date ) {
		$this->location = (isset($postmeta['location'])) ? $postmeta['location'][0] : '';
		$this->lat = (isset($postmeta['lat'])) ? $postmeta['lat'][0] : '';
		$this->lng = (isset($postmeta['lng'])) ? $postmeta['lng'][0] : '';
		$this->description = (isset($postmeta['description'])) ? $postmeta['description'][0] : '';
		$this->name = (isset($postmeta['name'])) ? $postmeta['name'][0] : '';
		$this->status = (isset($postmeta['status'])) ? $postmeta['status'][0] : 'publish';
		$this->date = $date;
	}
}