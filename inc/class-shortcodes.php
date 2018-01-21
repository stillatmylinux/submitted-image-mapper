<?php

class SimShortcodes {
	public function hooks() {
		add_shortcode('sim-thankyou', array($this, 'thankyou'));
		add_shortcode('sim-need-location-map', array($this, 'need_location_map'));
	}

	public function thankyou() {
		ob_start();
		simgmap_get_template_part( 'upload', 'thank-you' );
		return ob_get_clean();
	}

	public function need_location_map() {
		ob_start();
		simgmap_get_template_part( 'upload', 'mark-location' );
		return ob_get_clean();
	}
}