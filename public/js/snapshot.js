navigator.getUserMedia = (navigator.getUserMedia ||
    navigator.webkitGetUserMedia ||
    navigator.mozGetUserMedia ||
    navigator.msGetUserMedia);

var constraints = {
    video: { width: 800, height: 460},
    audio: false
};

document.getElementById('is_video').value = 'true';
document.getElementById('is_image').value = 'false';
var w;
var h;

var current;
var PosX = 0;
var PosY = 0;


if (navigator.getUserMedia)
    navigator.getUserMedia(constraints, successCallback, errorCallback);
else
    alert("getUserMedia not supported");

function successCallback(localMediaStream) {
    var video = document.getElementById('video');
    if ("srcObject" in video) {
        video.srcObject = localMediaStream;
      } else {
        // For older browsers.
        video.src = window.URL.createObjectURL(localMediaStream);
      }
    video.play();
    document.getElementById('infoblock').style.display = '';
};

function errorCallback(err) {
    document.getElementById('is_video').value = 'false';
    document.getElementById('infoblock').style.display = 'none';
};

function takeShot() {
   // document.getElementById('snap').disabled = true;
    if (document.getElementById('is_video').value == 'true'){
        shotFromVideo();
    }
}
function shotFromVideo() {
        var video = document.getElementById('video');
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var filter = document.querySelector('input[name = "img_filter"]:checked');
        if (filter) {
            if (document.getElementById('is_video').value == 'true') {
                canvas.width = video.getBoundingClientRect().width;
                canvas.height = video.getBoundingClientRect().height;
                canvas.id = "cvideo";
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                }
            var imgFromWebcam = canvas.toDataURL('image/png');
            canvas.setAttribute('src', imgFromWebcam);
            document.getElementById('imgToSend').value = imgFromWebcam;
            document.getElementById('imgToSend').width = canvas.width;
            document.getElementById('imgToSend').height = canvas.height;
        }
}


function createFilterToUpload() {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var filter = document.querySelector('input[name = "img_filter"]:checked');
    if (filter) {
            if (document.getElementById('is_image').value == 'true') {
            canvas.width = document.getElementById("filterwidth").value;
            canvas.height = document.getElementById("filterheight").value;
                var img = new Image();
                img.src = filter.value;
                size = canvas.width / 3;
                context.drawImage(img, PosX, PosY, size, size);
            } 
            var imgFilter = canvas.toDataURL('image/png');
            document.getElementById('filterpp').value = imgFilter;
        }
    }

function readURL(input) {
    var PicUploadPath = document.getElementById('localImage').value;
    var Extension = PicUploadPath.substring(PicUploadPath.lastIndexOf('.') + 1).toLowerCase();
    if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
        if (input.files && input.files[0]) {
            if (input.files[0].size > 50000000) {
                alert('Image size should not be over 50 MB.');
            } else if (input.files[0].size <= 0) {
                alert('Invalid Image.');
            } else {
                var reader = new FileReader();
                reader.readAsDataURL(input.files[0]);
                image = document.getElementById('imgUploaded');
                imageBox = document.getElementById('imgUploadedBox');
                reader.onload = function(e) {
                    var img = new Image();
                    img.src = e.target.result;
                    img.onload = function (e){
                        document.getElementById("filterwidth").value = img.width;
                        document.getElementById("filterheight").value = img.height;
                        imageBox.style.display = "";
                        image.style.display = "";
                        image.setAttribute('src', img.src);
                        document.getElementById('imgToSend').value = img.src;
                        document.getElementById('imgToSend').width = img.width;
                        document.getElementById('imgToSend').height = img.height;
                    }
                    document.getElementById('infoblock').style.display = '';
                };
            }
        } else {
            image.style.display = null;
            image.setAttribute('src', "");
            imageBox.style.display = "none";
        } } else
            alert('Only the following extentions are allowed: PNG, JPG, JPEG. ');
}

window.addEventListener('resize', function(event){
    myimage(current);
  });

function myimage(img_url) {
    current = img_url;
    document.getElementById('snap').disabled = false;
    if ((document.getElementById('is_image').value == 'true') && img_url) {
        var elementImg = document.getElementById("filtercanvasimg");
        if (elementImg)
            elementImg.parentNode.removeChild(elementImg);
        var canvasImg = document.createElement('canvas');
        var contextImg = canvasImg.getContext('2d');
        canvasImg.width = document.getElementById('imgUploaded').getBoundingClientRect().width;
        canvasImg.height = document.getElementById('imgUploaded').getBoundingClientRect().height;
        canvasImg.draggable = true;
        canvasImg.id = "filtercanvasimg";
        canvasImg.style = "position: absolute; top: 20px; left: 20px;"
        document.getElementById("imgUploadedBox").appendChild(canvasImg);
        if (isInArray(document.getElementById(img_url).value)) {
            var img = new Image();
            img.src = document.getElementById(img_url).value;
            img.size = canvasImg.width / 3;
            contextImg.drawImage(img, PosX, PosY, img.size, img.size);
            createFilterToUpload();
        }else
            document.getElementById('filterpp').value = '';
    }
    if ((document.getElementById('is_video').value == 'true') && img_url)
    {
        var element = document.getElementById("filtercanvasvid");
        if (element)
            element.parentNode.removeChild(element);
        var canvas = document.createElement('canvas');
        var contextVid = canvas.getContext('2d');
        canvas.width = document.getElementById('video').getBoundingClientRect().width;
        canvas.height = document.getElementById('video').getBoundingClientRect().height;
        canvas.draggable = true;
        canvas.id = "filtercanvasvid";
        canvas.style = "position: absolute; top: 0px; left: 0px;"
        document.getElementById("Webcam").appendChild(canvas);
        if (isInArray(document.getElementById(img_url).value)) {
                var imgVid = new Image();
                imgVid.src = document.getElementById(img_url).value;
                imgVid.size = canvas.width / 3;
                contextVid.drawImage(imgVid, PosX, PosY, imgVid.size, imgVid.size);
                // Create Filter image to send
                var imgFilter = canvas.toDataURL('image/png');
                document.getElementById('filterpp').value = imgFilter;
        }else
            document.getElementById('filterpp').value = '';
    }
}

function isInArray(val) {
    const array = ["public/filters/1.png", "public/filters/2.png", "public/filters/3.png", "public/filters/4.png", "public/filters/5.png", 
    "public/filters/6.png", "public/filters/7.png", "public/filters/8.png", "public/filters/9.png", "public/filters/10.png", ];
    if (array.indexOf(val) >= 0)
        return true;
    return false;
}