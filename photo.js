// self invoking function
(function() {
    var video = document.getElementById('video'),
    canvas = document.getElementById('canvas'),
    context = canvas.getContext('2d'),
    photo = document.getElementById('photo'),
    vendorUrl = window.URL || window.webkitURL;

        //browser compatibility 
    navigator.getMedia = navigator.getUserMedia ||
                            navigator.webkitGetUserMedia ||
                            navigator.mozGetUserMedia ||
                            navigator.msGetUserMedia;

    // this function takes three arguments (properties, success callback, error)
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream){
        // create video src attribute
        // create object url from stream using vendorURL then play video
        //video.src = vendorUrl.createObjectURL(stream);
        video.srcObject = stream;
        video.play();
    }, function(error){
        // An error occured
        // error.code
        alert("Video capture error: ", error.code);
    });

    document.getElementById('capture').addEventListener('click', function(){
        context.drawImage(video, 0, 0, 400, 300);
        // merging the images should be here
        // taking the image as png from canvas and placing it in img
        photo.setAttribute('src', canvas.toDataURL('image/png'));
    });
})();