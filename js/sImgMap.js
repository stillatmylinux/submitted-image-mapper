;(function() {

	var sImgMap = {
		recentMap: {
			domSelectorId: '',
			callback: null
		},
		api: {
			url: 'https://maps.googleapis.com/maps/api/js?',
			key: ''
		}
	};
	sImgMap.init = function() {
		if(appcamera) {
			console.log('we found the appcamera.js');
			appcamera.upload = {
				callback: sImgMap.uploadCallback
			}
		} else {
			console.log('missing appcamera');
		}
	}
	sImgMap.add_mapapi = function() {
		var src = sImgMap.api.url+'callback=sImgMap.recentMap.callback&key='+sImgMap.api.key;
		var s = document.createElement('script');
		var async = document.createAttribute('async');
		s.setAttributeNode(async);
		var defer = document.createAttribute('defer');
		s.setAttributeNode(defer);
		s.src = src;
    	document.body.appendChild(s);
	}
	sImgMap.getTestData = function(url) {
		var script = document.createElement('script');
		script.src = url;
		document.getElementsByTagName('head')[0].appendChild(script);
	}
	sImgMap.recentMap.addLocations = function() {
		var bounds = new google.maps.LatLngBounds();
		var map = new google.maps.Map(document.getElementById(sImgMap.recentMap.domSelectorId), {
			center: sImgMap.recentMap.myLatLng,
			zoom: sImgMap.recentMap.zoom
		});
		var infowindow = new google.maps.InfoWindow();
		var locations = sImgMap.recentMap.locations;
		var Markers = {};

		for(var i=0; i<locations.length; i++) {
			var position = new google.maps.LatLng(locations[i].lat, locations[i].lng);
			bounds.extend(position);
			var marker = new google.maps.Marker({
				position: position,
				map: map,
			});

			google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
					infowindow.setContent(locations[i].infowindowContent);
					infowindow.setOptions({maxWidth: 200});
					infowindow.open(map, marker);
				}
			}) (marker, i));
			Markers[i] = marker;
		}

		bounds.extend(sImgMap.recentMap.myLatLng);

		map.fitBounds(bounds);       // auto-zoom
		map.panToBounds(bounds);     // auto-center
	}
	sImgMap.uploadCallback = function(uploadResponse) {
		console.log('sImgMap.uploadCallback uploadResponse', uploadResponse);
		let resp = uploadResponse;
		if(resp && resp.indexOf('{') === 0) {
			let json = JSON.parse(resp);
			if(json && json.success && json.data && json.data.location === false) {
				needLocation = true;
				window.location.href = 'http://home.thiessen.us/mark-location-map/?sim-post-id='+json.data.post_id+'&appp=3';
			} else {
				window.location.href = 'http://home.thiessen.us/thank-you/?sim-attachment-id='+json.data.attachment_id+'&appp=3';
			}
		}
	}

	window.sImgMap = sImgMap;
	sImgMap.init();

})();