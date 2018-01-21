<?php

if(isset($_GET['sim-attachment-id'])) {
	echo '<img src="'. wp_get_attachment_url( (int)$_GET['sim-attachment-id'] ) .'">';
}