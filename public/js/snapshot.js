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
document.getElementById('is_video').value = 'true';
document.getElementById('is_image').value = 'false';
var w;
var h;

var current;
 var PosX = 0;
 var PosY = 0;
//var PosX = 270;
//var PosY = 70;

var size = 320;


//var httpr = new XMLHttpRequest();

if (navigator.getUserMedia)
    navigator.getUserMedia(constraints, successCallback, errorCallback);
else
    console.error("getUserMedia not supported");

function successCallback(localMediaStream) {
    var video = document.getElementById('video');
    if ("srcObject" in video) {
        video.srcObject = localMediaStream;
      } else {
        // Avoid using this in new browsers, as it is going away.
        video.src = window.URL.createObjectURL(localMediaStream);
      }
    video.play();
    document.getElementById('infoblock').style.display = '';
};

function errorCallback(err) {
    is_video = false;
    document.getElementById('is_video').value = 'false';
    document.getElementById('infoblock').style.display = 'none';
    //console.log("error : " + err);
};

// localMediaStream.getTracks().forEach(function(track) {
//     track.stop();
//   });

// function Shot() {
//     if (is_video == true || is_image == true) {
//         var video = document.querySelector('video');
//         var canvas = document.createElement('canvas');
//         var imageUploaded = document.getElementById('imgUploaded');
//         var context = canvas.getContext('2d');
//         var filter = document.querySelector('input[name = "img_filter"]:checked');
//         if (filter) {
            

//             if (document.getElementById('is_image').value == 'true') {
//             canvas.width = imageUploaded.getBoundingClientRect().width;
//             canvas.height = imageUploaded.getBoundingClientRect().height;
//             canvas.id = "cimg";
//             element = document.getElementById("cimg");
//             if (element)
//                 element.parentNode.removeChild(element);
//             document.getElementById("canvasupload").appendChild(canvas);
//                // console.log("yes");
//                 var image = new Image();
//                 image.src = document.getElementById('imgUploaded').src;
//                 width = document.getElementById('imgUploaded').getBoundingClientRect().width;
//                 height = document.getElementById('imgUploaded').getBoundingClientRect().height;
//                 context.drawImage(image, 0, 0, width, height);
//                 var img = new Image();
//                 img.src = filter.value;
//                 size = width / 3;
//                 context.drawImage(img, PosX, PosY, size, size);
//             } else if (document.getElementById('is_video').value == 'true') {
//             canvas.width = video.getBoundingClientRect().width;
//             canvas.height = video.getBoundingClientRect().height;
//             canvas.id = "cvideo";
//             element = document.getElementById("cvideo");
//             if (element)
//                 element.parentNode.removeChild(element);
//             document.getElementById("canvasvideo").appendChild(canvas);
//                 width = document.getElementById('video').getBoundingClientRect().width;
//                 height = document.getElementById('video').getBoundingClientRect().height;
//                 context.drawImage(video, 0, 0, width, height);
//                 var img = new Image();
//                 img.src = filter.value;
//                 size = width / 3;
//                 context.drawImage(img, PosX, PosY, size, size);
//             }

//             var imgMerged = canvas.toDataURL('image/png');
//             canvas.setAttribute('src', imgMerged);
//             document.getElementById('imgToSend').value = imgMerged;
//             document.getElementById('imgToSend').width = canvas.width;
//             document.getElementById('imgToSend').height = canvas.height;
            
//             var data = new FormData(document.forms["formWithImage"]);
//             httpr.open('POST', 'index.php?page=uploadMergeImg');
//             httpr.send(data);
//         }
//     } else
//         alert("You need to activate your Webcam or Upload an image.");
// }
function takeShot() {
    if (document.getElementById('is_video').value == 'true'){
        shotFromVideo();
    }
}
function shotFromVideo() {
   // if (is_video == true) {
        var video = document.getElementById('video');
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var filter = document.querySelector('input[name = "img_filter"]:checked');
        if (filter) {
            if (document.getElementById('is_video').value == 'true') {
                canvas.width = video.getBoundingClientRect().width;
                canvas.height = video.getBoundingClientRect().height;
                canvas.id = "cvideo";
                // element = document.getElementById("cvideo");
                // if (element)
                //     element.parentNode.removeChild(element);
                // document.getElementById("canvasvideo").appendChild(canvas);
                    // width = document.getElementById('video').getBoundingClientRect().width;
                    // height = document.getElementById('video').getBoundingClientRect().height;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);
                }
            var imgFromWebcam = canvas.toDataURL('image/png');
            canvas.setAttribute('src', imgFromWebcam);
            document.getElementById('imgToSend').value = imgFromWebcam;
            document.getElementById('imgToSend').width = canvas.width;
            document.getElementById('imgToSend').height = canvas.height;
        }
    // } else
    //     alert("You need to activate your Webcam or Upload an image.");
}


function createFilterToUpload() {
    var canvas = document.createElement('canvas');
    var imageUploaded = document.getElementById('imgUploadedBox');
    var context = canvas.getContext('2d');
    var filter = document.querySelector('input[name = "img_filter"]:checked');
    if (filter) {
        

        if (document.getElementById('is_image').value == 'true') {
        canvas.width = document.getElementById("filterwidth").value;
        canvas.height = document.getElementById("filterheight").value;
        //canvas.id = "cimg";
        // element = document.getElementById("cimg");
        // if (element)
        //     element.parentNode.removeChild(element);
        // document.getElementById("canvasupload").appendChild(canvas);
           // console.log("yes");
            var img = new Image();
            img.src = filter.value;
            size = canvas.width / 3;
            context.drawImage(img, PosX, PosY, size, size);
        } 

        var imgFilter = canvas.toDataURL('image/png');
        //canvas.setAttribute('src', imgMerged);
        document.getElementById('filterpp').value = imgFilter;
        // document.getElementById('filterWidth').value = canvas.width;
        // document.getElementById('filterHeight').value = canvas.height;
        
       
    }}

    function createFilterToWebcam() {
        var canvas = document.createElement('canvas');
        var video = document.getElementById('video');
        var context = canvas.getContext('2d');
        var filter = document.querySelector('input[name = "img_filter"]:checked');
        if (filter) {
            if (document.getElementById('is_video').value == 'true') {
            canvas.width = video.getBoundingClientRect().width;
            canvas.height = video.getBoundingClientRect().height;
            var img = new Image();
            img.src = filter.value;
            size = canvas.width / 3;
            context.drawImage(img, PosX, PosY, size, size);
            }
            var imgFilter = canvas.toDataURL('image/png');
            //canvas.setAttribute('src', imgMerged);
            document.getElementById('filterpp').value = imgFilter;
            // document.getElementById('filterWidth').value = canvas.width;
            // document.getElementById('filterHeight').value = canvas.height;
        }
    }
    
    // function createImageToUpload() {
    //     var canvas = document.createElement('canvas');
    //     var imageUploaded = document.getElementById('imgUploaded');
    //     var context = canvas.getContext('2d');
      
    //         if (document.getElementById('is_image').value == 'true') {
    //         canvas.width = imageUploaded.getBoundingClientRect().width;
    //         canvas.height = imageUploaded.getBoundingClientRect().height;

    //             var img = new Image();
    //             img.src = imageUploaded.src;
    //             context.drawImage(img, 0, 0, canvas.width, canvas.height);
    //         } 
    
    //         var imgMerged = canvas.toDataURL('image/jpeg');
    //         //canvas.setAttribute('src', imgMerged);
    //         document.getElementById('imgToSend').value = imgMerged;
    //         document.getElementById('imgToSend').width = canvas.width;
    //         document.getElementById('imgToSend').height = canvas.height;
    // }

function readURL(input) {
    var PicUploadPath = document.getElementById('localImage').value;
    var Extension = PicUploadPath.substring(PicUploadPath.lastIndexOf('.') + 1).toLowerCase();
    if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {
        if (input.files && input.files[0]) {
            //console.log("size = " + input.files[0].size);
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
                        // img.width = 720;
                        // img.height = 480;
                        document.getElementById("filterwidth").value = img.width;
                        document.getElementById("filterheight").value = img.height;
                        // var height = this.height;
                        // var width = this.width;
                        
                        imageBox.style.display = "";
                        image.style.display = "";
                        // image.height = height;
                        // image.width = width;
                        // console.log("width1 - " + image.width);
                        // console.log("height1 - " + image.height);
                        // img.width = image.width;
                        // img.height = image.height;
                        image.setAttribute('src', img.src);
                        // console.log("width - " + img.width);
                        // console.log("height - " + img.height);
                        document.getElementById('imgToSend').value = img.src;
                        document.getElementById('imgToSend').width = img.width;
                        document.getElementById('imgToSend').height = img.height;
                    }
                    document.getElementById('infoblock').style.display = '';
                    //createImageToUpload();
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
    if (document.getElementById('imgUploaded').src && img_url) {
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
        var img = new Image();
        img.src = document.getElementById(img_url).value;
        img.size = canvasImg.width / 3;
        contextImg.drawImage(img, PosX, PosY, img.size, img.size);
        createFilterToUpload();
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
        var imgVid = new Image();
        imgVid.src = document.getElementById(img_url).value;
        imgVid.size = canvas.width / 3;
        contextVid.drawImage(imgVid, PosX, PosY, imgVid.size, imgVid.size);
        // Create Filter image to send
        var imgFilter = canvas.toDataURL('image/png');
        document.getElementById('filterpp').value = imgFilter;
        //createFilterToWebcam();
    }

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


// document.getElementById("Webcam").onmousemove = (e) => {

//     var rect = document.getElementById('Webcam').getBoundingClientRect();
//     width = document.getElementById('video').getBoundingClientRect().width;
//     PosX = e.clientX - rect.left - (width / 2);
//     PosY = e.clientY - rect.top - (width / 2);
//     myimage(current);
//   }

// function changePosition(e){
//     var rect = document.getElementById('Webcam').getBoundingClientRect();
//     width = document.getElementById('video').getBoundingClientRect().width;
//     PosX = e.clientX - rect.left - (width / 2);
//     PosY = e.clientY - rect.top - (width / 2);
//     myimage(current);
// }

// function getClickPosition(e) {
//     if (current) {
//         var rect = document.getElementById('Webcam').getBoundingClientRect();
//         PosX = e.clientX - rect.left - (width / 2);
//         PosY = e.clientY - rect.top - (width / 2);
//         myimage(current);
//     }
// }


/*window.addEventListener("unload", function(){
    localMediaStream.getTracks().forEach(function(track) {
        track.stop();
      });
})*/

