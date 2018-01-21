<?php

// Get the photos

$subimgMapper = new SubmittedImageMapper();
$post_type = 'submitted-pic';
$photoList = $subimgMapper->getPhotoList( $post_type );
$jsPhotoList = ($photoList) ? json_encode($photoList) : '{}';

?>

<div id="map-recent" style="width:100%;height:100vh;min-height:680px"></div>
<script>
	
	// Config
	sImgMap.api.key = '<?php echo $subimgMapper->getGoogleApi() ?>';
	sImgMap.recentMap.callback = sImgMap.recentMap.init;
	sImgMap.recentMap.domSelectorId = 'map-recent';

	// init
	sImgMap.recentMap.init = function() {
		sImgMap.recentMap.myLatLng = {lat: 32.2974358, lng:-85.4809466};
		sImgMap.recentMap.zoom = 7;
		sImgMap.recentMap.locations = <?php echo $jsPhotoList ?>;
		sImgMap.recentMap.addLocations();
	}

	// check to see if the Google API already exists
	if(typeof google === 'undefined' || typeof google.maps === 'undefined') {
		sImgMap.add_mapapi(); // calls our callback (init) after loading (see the URL)
	} else {
		sImgMap.recentMap.init();
	}

</script>