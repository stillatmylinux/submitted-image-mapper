<?php



$subimgMapper = new SubmittedImageMapper();
$post_type = 'submitted-pic';
$photoList = $subimgMapper->getPhotoList( $post_type );

$jsPhotoList = ($photoList) ? json_encode($photoList) : '{}';

?>sImgMap.recentMap.dataCallback({
		"type":"FeatureCollection",
		"metadata":{
			"generated":1515267089000,
			"url":"/test-data-2.geojsonp.php",
			"title":"Redzone weather submitted photos",
			"status":200,
			"api":"1.0.0",
			"count":2
		},
		"features":[
			{
				"id":"us1000c1hr",
				"type":"Feature",
				"properties":{
					"time":1515263710840,
					"updated":1515264755040,
					"description": "hi",
					"title":"M 5.0 - 193km SE of Sarangani, Philippines"
				},
				"geometry":{
					"type":"Point",
					"coordinates":[-86.6336466,32.281625]
				}
			},
			{"type":"Feature","properties":{"mag":4.6,"place":"188km SSE of Taron, Papua New Guinea","time":1515262503520,"updated":1515266837040,"tz":600,"url":"https://earthquake.usgs.gov/earthquakes/eventpage/us1000c1hh","detail":"https://earthquake.usgs.gov/earthquakes/feed/v1.0/detail/us1000c1hh.geojsonp","felt":null,"cdi":null,"mmi":null,"alert":null,"status":"reviewed","tsunami":0,"sig":326,"net":"us","code":"1000c1hh","ids":",us1000c1hh,","sources":",us,","types":",geoserve,origin,phase-data,","nst":null,"dmin":2.365,"rms":0.84,"gap":149,"magType":"mb","type":"earthquake","title":"M 4.6 - 188km SSE of Taron, Papua New Guinea"},"geometry":{"type":"Point","coordinates":[153.6322,-6.0622,6.74]},"id":"us1000c1hh"}
		],
		"bbox":[-179.6805,-53.0266,0,178.7923,76.9531,587.51]
});