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
			document.addEventListener('appgeo-checkin', sImgMap.handle_checkin);
		} else {
			console.log('missing appcamera');
		}
	}
	sImgMap.handle_checkin = function(event) {
		console.log('sImgMap.handle_checkin detail', event, event.detail);
		if(event.detail && event.detail.data && event.detail.data.post_id) {
			var post_id = jQuery('#submitted-photo').data('postId');
			var lat = event.detail.data.latitude;
			var lng = event.detail.data.longitude;

			console.log({
				post_id: post_id,
				lat: lat,
				lng: lng
			});

			sImgMap.add_geolocation_post({
				post_id: post_id,
				lat: lat,
				lng: lng
			});
		}
	}
	sImgMap.add_geolocation_post = function(data) {

		data.action = 'sim_post_location';

		jQuery.ajax({
			type: 'POST',
			url: apppCore.ajaxurl,
			data: data,
			success: function( response ){

				try {
					console.log('sImgMap.add_geolocation_post ajax response', response);
					var event = new CustomEvent('sim-post-location', {detail:response});
					window.document.dispatchEvent(event);
				} catch (error) {
					console.warn(error);
				}

				var redirect = jQuery('#submitted-photo-redirect').data('redirect');
				if(redirect) {
					window.location.href = redirect+'?appp=3&sim-attachment-id='+response.data.attachment_id;
				}

			},
			error: function( error ) {
				console.log('sImgMap.add_geolocation_post ajax error', error);
			}
		});
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
	sImgMap.getIconColor = function(color) {
		/*
		Blue: blue-dot.png
		Red: red-dot.png
		Purple: purple-dot.png
		Yellow: yellow-dot.png
		Green: green-dot.png
		*/

		switch(color) {
			case 'blue':
				png = 'blue-dot.png';
				break;
			case 'red':
				png = 'red-dot.png';
				break;
			case 'purple':
				png = 'purple-dot.png';
				break;
			case 'yellow':
				png = 'yellow-dot.png';
				break;
			case 'green':
				png = 'green-dot.png';
				break;
			default:
				png = 'blue-dot.png';
				break;
		}

		return 'http://maps.google.com/mapfiles/ms/icons/'+png;
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
				icon: sImgMap.getIconColor(locations[i].color)
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
				if(simgmapUrls && simgmapUrls.dropMarkerPage) {
					window.location.href = dropMarkerPage+'?sim-post-id='+json.data.post_id+'&appp=3';
				}
			} else {
				if(simgmapUrls && simgmapUrls.thankyouPage) {
					window.location.href = simgmapUrls.thankyouPage+'?sim-attachment-id='+json.data.attachment_id+'&appp=3';
				}
			}
		}
	}

	window.sImgMap = sImgMap;
	sImgMap.init();

})();