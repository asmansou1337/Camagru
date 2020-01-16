navigator.getUserMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

var constraints = {
    video: { width: 800, height: 460},
    //video: true,
    audio: false
};
var is_video = true;
var is_image = false;

var current;
//var PosX = 200;
//var PosY = 200;
var PosX = 270;
var PosY = 70;

var size = 320;

if (navigator.getUserMedia)
    navigator.getUserMedia(constraints, successCallback, errorCallback);
else
    console.error("getUserMedia not supported");

function successCallback(localMediaStream) {
    var video = document.querySelector('video');
    video.srcObject = localMediaStream;
   // video.src = window.URL.createObjectURL(localMediaStream);
    video.play();
    // is_video = true;
    // is_image = false;
    /*if(is_video == false)
    {
        localMediaStream.getTracks().forEach(function(track) {
            track.stop();
          });
    }*/
};

function errorCallback(err) {
    is_video = false;
    console.log("error : " + err);
};

localMediaStream.getTracks().forEach(function(track) {
    track.stop();
  });

function Shot() {
    if (is_video == true || is_image == true) {
        var video = document.querySelector('video');
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var filter = document.querySelector('input[name = "img_filter"]:checked');
        if (filter) {
            canvas.width = 800;
            canvas.height = 460;
            cv = document.getElementById("canvas");
            if(cv.firstChild)
                cv.insertBefore(canvas, cv.firstChild);
            else
                cv.appendChild(canvas);

            if (document.getElementById('imgUploaded').src) {
                var image = new Image();
                image.src = document.getElementById('imgUploaded').src;
                context.drawImage(image, 0, 0, 800, 460);
            } else
                context.drawImage(video, 0, 0, 800, 460);

            var img = new Image();
            img.src = filter.value;
            context.drawImage(img, PosX, PosY, size, size);

            var data = canvas.toDataURL('image/png');
            canvas.setAttribute('src', data);
           // document.getElementById('img').value = data;

            // var fd = new FormData(document.forms["form"]);
            // var httpr = new XMLHttpRequest();
            // httpr.open('POST', 'dropimg.php', true);
            // httpr.send(fd);
        } else
            alert("Vous devez d'abord selectionner un filtre.");
    } else
        alert("Vous devez d'abord activer votre webcam ou choisir une image.");
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        image = document.getElementById('imgUploaded');
        imageBox = document.getElementById('imgUploadedBox');
        reader.onload = function(e) {
            imageBox.style.display = "";
            image.style.display = "";
            image.setAttribute('src', e.target.result);
            // image.height = 460;
            // image.width = 800;
            //document.getElementById('video').style.display = "none";
        };
        reader.readAsDataURL(input.files[0]);
        is_image = true;
        is_video = false;
    } else {
        image.style.display = null;
        image.setAttribute('src', "");
        imageBox.style.display = "none";
    }
}

function myimage(img_url) {
    if ((is_video == true || is_image == true) && img_url) {
        current = img_url;
        var element = document.getElementById("filtercanvas");
        if (element)
            element.parentNode.removeChild(element);
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        canvas.width = 800;
        canvas.height = 460;
        canvas.draggable = true;
        canvas.id = "filtercanvas";
        //canvas.addEventListener("click", getClickPosition, false);
        if (is_video)
            document.getElementById("canvasvideo").appendChild(canvas);
        if (is_image)
            document.getElementById("canvasImage").appendChild(canvas);
        var img = new Image();
        img.src = document.getElementById(img_url).value;
        context.drawImage(img, PosX, PosY, size, size);
    }
}

// function getClickPosition(e) {
//     if (current) {
//         var rect = document.getElementById('canvasvideo').getBoundingClientRect();
//         PosX = e.clientX - rect.left - (width / 2);
//         PosY = e.clientY - rect.top - (width / 2);
//         myimage(current);
//     }
// }

window.addEventListener("unload", function(){
    localMediaStream.getTracks().forEach(function(track) {
        track.stop();
      });
})

