<?php

// Get the photos

$subimgMapper = new SubmittedImageMapper();
$post_type = 'submitted-pic';

// within the last 3 hours
$timeframe = array(
	'after' => '3 hours ago', // weird opposite logic
);

$photoList = $subimgMapper->getPhotoList( $post_type, $timeframe );
$jsPhotoList = ($photoList) ? json_encode($photoList) : '{}';

?>

<div id="map-recent" style="width:100%;height:100vh;min-height:480px"></div>
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
<div class="photo-list">
<?php $photoList = array_reverse($photoList); ?>
<?php foreach($photoList as $photo) : ?>
	<h2 style="color:<?php echo $photo->color ?>"><?php echo $photo->getPost()->post_title ?></h2>
	<p><img style="max-height:100px;" src="<?php echo $photo->image ?>"></p>
<?php endforeach;?>
</div>