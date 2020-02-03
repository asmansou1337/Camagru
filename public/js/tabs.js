
function openTab(evt, tabName) {
    var i, x, tablinks;
    x = document.getElementsByClassName("content-tab");
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tab");
    for (i = 0; i < x.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" is-active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " is-active";
    if (tabName == "Webcam")
    {
        // document.getElementById('imgUploaded').src != null;
        document.getElementById('infoblock').style.display = '';
        document.getElementById('imgToSend').value = "";
        document.getElementById('title').value = "";
        document.getElementById('description').value = "";
        image = document.getElementById('imgUploaded');
        imageBox = document.getElementById('imgUploadedBox');
        image.style.display = null;
        //image.setAttribute('src', null);
        imageBox.style.display = "none";
        document.getElementById('is_video').value = 'true';
        document.getElementById('is_image').value = 'false';
    } else {
        document.getElementById('imgToSend').value = "";
        document.getElementById('title').value = "";
        document.getElementById('description').value = "";
        document.getElementById('infoblock').style.display = 'none';
        document.getElementById('is_video').value = 'false';
        document.getElementById('is_image').value = 'true';
    }
  }