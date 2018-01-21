
// Required modification to AppPresser's AP3 code app-camera.ts

uploadPhoto(camImage) {

    let imageURI = '';

    console.log(typeof camImage, camImage);

    if(typeof camImage === 'object') {
      imageURI = camImage.filename;
    } else if(camImage.indexOf('{') === 0) {
      let img = JSON.parse(camImage);
      imageURI = img.filename;
    } else {
      imageURI = camImage;
    }
