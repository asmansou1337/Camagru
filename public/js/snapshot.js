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
var w;
var h;

var current;
// var PosX = 0;
// var PosY = 0;
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
    //var canvas = document.getElementById("filtercanvasvid");
    //canvas.width = document.getElementById('video').getBoundingClientRect().width;
    //canvas.height = document.getElementById('video').getBoundingClientRect().height;
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

// localMediaStream.getTracks().forEach(function(track) {
//     track.stop();
//   });

function Shot() {
    // is_video = document.getElementById('is_video').value;
    // is_image = document.getElementById('is_image').value;
   // console.log("video " + is_video);
   // console.log("image " + is_image);
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

            if (document.getElementById('is_video').value == 'false') {
                var image = new Image();
                image.src = document.getElementById('imgUploaded').src;
                context.drawImage(image, 0, 0, 800, 460);
                // size = image.getBoundingClientRect().width;
            } else {
                context.drawImage(video, 0, 0, 800, 460);
                // size = video.getBoundingClientRect().width;
            }
                

          //  console.log("value " + document.getElementById('is_video').value);

            // width = video.getBoundingClientRect().width;
            


            var img = new Image();
            img.src = filter.value;
            context.drawImage(img, PosX, PosY, size, size);

            var imgMerged = canvas.toDataURL('image/png');
            canvas.setAttribute('src', imgMerged);
            document.getElementById('imgToSend').value = imgMerged;
            document.getElementById('imgToSend').width = canvas.width;
            document.getElementById('imgToSend').height = canvas.height;
            
            var data = new FormData(document.forms["formWithImage"]);
            var httpr = new XMLHttpRequest();
            httpr.open('POST', 'index.php?page=uploadMergeImg');
            httpr.send(data);
        }
    } else
        alert("You need to activate your Webcam or Upload an image.");
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
            image.height = 460;
            image.width = 800;
            //document.getElementById('video').style.display = "none";
        };
        reader.readAsDataURL(input.files[0]);
        //is_image = true;
        //is_video = false;
    } else {
        image.style.display = null;
        image.setAttribute('src', "");
        imageBox.style.display = "none";
    }
}

window.addEventListener('resize', function(event){
    var cv=document.getElementById('filtercanvasvid');
    cv.setAttribute('width', window.innerWidth);
    cv.setAttribute('height', window.innerHeight);
    size = window.innerWidth / 3;
    var rect = document.getElementById('video').getBoundingClientRect();
    PosX = rect.top;
    PosY = rect.left;
    //console.log("posX = " + PosX + " PosY = " + PosY);
  });

function myimage(img_url) {
    current = img_url;
    if (document.getElementById('imgUploaded').src && img_url) {
        var elementImg = document.getElementById("filtercanvasimg");
        if (elementImg)
            elementImg.parentNode.removeChild(elementImg);
        var canvasImg = document.createElement('canvas');
        var contextImg = canvasImg.getContext('2d');
       // canvasImg.width = document.getElementById('imgUploadedBox').getBoundingClientRect().width;
       // canvasImg.height = document.getElementById('imgUploadedBox').getBoundingClientRect().height;
        canvas.setAttribute('width', window.innerWidth);
        canvas.setAttribute('height', window.innerHeight);
        canvasImg.draggable = true;
        canvasImg.id = "filtercanvasimg";
        document.getElementById("canvasImage").appendChild(canvasImg);
        var img = new Image();
        img.src = document.getElementById(img_url).value;
        contextImg.drawImage(img, PosX, PosY, size, size);
    }
    if (is_video && img_url)
    {
        var element = document.getElementById("filtercanvasvid");
        if (element)
            element.parentNode.removeChild(element);
        var canvas = document.createElement('canvas');
        var contextVid = canvas.getContext('2d');
        canvas.width = document.getElementById('video').getBoundingClientRect().width;
        canvas.height = document.getElementById('video').getBoundingClientRect().height;
        //canvas.setAttribute('width', window.innerWidth);
        //canvas.setAttribute('height', window.innerHeight);
        //canvas.width = w;
        //canvas.height = h;
        canvas.draggable = true;
        canvas.id = "filtercanvasvid";
        document.getElementById("canvasvideo").appendChild(canvas);
        var imgVid = new Image();
        imgVid.src = document.getElementById(img_url).value;
        contextVid.drawImage(imgVid, PosX, PosY, size, size);
    }
    document.getElementById('snap').disabled = false;

    // if ((is_video == true || is_image == true) && img_url) {
    //     var element = document.getElementById("filtercanvas");
    //     if (element)
    //         element.parentNode.removeChild(element);
    //     var canvas = document.createElement('canvas');
    //     var context = canvas.getContext('2d');
    //     canvas.width = document.getElementById('video').getBoundingClientRect().width;
    //     canvas.height = document.getElementById('video').getBoundingClientRect().height;
    //     canvas.draggable = true;
    //     canvas.id = "filtercanvas";
    //     //canvas.style.display = "block";
    //     //canvas.addEventListener("click", getClickPosition, false);
    //     // if (is_video)
    //     //     document.getElementById("canvasvideo").appendChild(canvas);
    //     //if (is_image) 
    //         document.getElementById("canvasImage").appendChild(canvas);
    //     // } else {
    //     //     document.getElementById("canvasvideo").appendChild(canvas);
    //     // }

    //     // if (is_video)
    //         document.getElementById("canvasvideo").appendChild(canvas);


    //     var img = new Image();
    //     img.src = document.getElementById(img_url).value;
    //     context.drawImage(img, PosX, PosY, size, size);
    // }
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
