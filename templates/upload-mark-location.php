<?php

if(isset($_GET['sim-post-id'])) {
	echo '<div id="submitted-photo" data-post-id="'. $_GET['sim-post-id'] .'"></div>';

	// redirect to the thank you page
	$thankyou_page_id = get_option('sim-thankyou-page');
	$thankyou_page_url = get_permalink($thankyou_page_id);
	echo '<div id="submitted-photo-redirect" data-redirect="'.$thankyou_page_url.'"></div>';
}
echo do_shortcode('[checkin class="checkin-button" button_text="Add your photo\'s location"]');