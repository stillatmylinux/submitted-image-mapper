/**
 * Submit images with geolocation
 * 
 * Custom js to be uploaded in the MyApppresser customizer
 */
(function(window, document) {

	window.document.addEventListener('appcamera-uploadwin', imageUploaded);

	function imageUploaded(event) {
		
		console.log('got the uploadwin event detail', event);

		var needLocation = false;
		var iframe = getEventIframe(event);
		var upload_callback = getAppCameraUploadCallback(iframe);
		
		if(iframe && upload_callback) {
			var upload_response = getUploadResponse(event);
			upload_callback(upload_response);
		}
	}
	
	function getEventIframe(event) {
		return (event && event.detail && event.detail.iframe) ? event.detail.iframe : false;
	}

	function getAppCameraUploadCallback(iframe) {
		return (iframe && iframe.appcamera && iframe.appcamera.upload && iframe.appcamera.upload.callback) ? iframe.appcamera.upload.callback : false;
	}

	function getUploadResponse(event) {
		return (event && event.detail && event.detail.response) ? event.detail.response : false;
	}
})(window, document, undefined);

