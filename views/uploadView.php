
<div class='container'>
<div class="columns">
  <div class="column is-three-quarters">
    <div class="box is-centered">
        <div class="tabs is-centered is-boxed">
            <ul>
                <li class="tab is-active" onclick="openTab(event,'Webcam')" >
                <a>
                    <span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
                    <span>Webcam</span>
                </a>
                </li>
                <li class="tab"  onclick="openTab(event,'local')">
                <a>
                    <span class="icon is-small"><i class="fas fa-download" aria-hidden="true"></i></span>
                    <span>Local Images</span>
                </a>
                </li>
            </ul>
        </div>

        <form method="post" name="formWithImage" enctype="multipart/form-data" action="index.php?page=uploadMergeImg">
                <div class="container">
                    <div id="Webcam" class="content-tab" style="position: relative; left: 0; top: 0;">
                        <video id="video" autoplay style="position: relative; left: 0; top: 0;"></video>
                        <!-- <div id="canvasvideo" style="position: absolute; top: 0px; left: -340px;"></div>-->
                        <div id="is_video" style="display:none"></div>
                        <div id="canvasvideo"></div>
                    </div>
                    <div id="local" class="content-tab" style="display:none">
                        <div class="container">
                            <div class="container" style="margin-bottom: 2rem;">
                                <div class="file is-centered">
                                    <label class="file-label">
                                        <input class="file-input" name="localImage" id="localImage" type='file' accept="image/*" onchange="readURL(this);" />
                                            <span class="file-cta">
                                                <span class="file-icon">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label">
                                                    Choose a file…
                                                </span>
                                            </span>
                                    </label>
                                </div>
                            </div>
                            <div class="box" id="imgUploadedBox" style="display:none; position: relative; left: 0; top: 0;">
                                <figure class="image is-5by4" style="position: relative; left: 0; top: 0;">
                                        <img id="imgUploaded" name="imgUploaded">
                                        <input type="hidden" name="imgUploadedWidth" id="imgUploadedWidth">
                                        <input type="hidden" name="imgUploadedHeight" id="imgUploadedHeight">
                                        <input type="hidden" name="filterpp" id="filterpp">
                                </figure>
                                <div id="canvasImage" style="position: absolute; top: 0px; left: 0px;"></div>
                                <div id="is_image" style="display:none"></div>
                                <div id="canvasupload"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" style="margin-top: 2rem;margin-bottom: 2rem;">
                    <input class="button is-large is-fullwidth is-link is-outlined" name="submit" id="snap" type="submit" value="Take A Picture" disabled>
                </div>
                
                <div id="canvas"></div>

                    <input id="imgToSend" name="imgToSend" type='hidden'>
        

        <div class="columns">
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/1.png" id="1" onchange="myimage('1')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/1.png">
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/2.png" id="2" onchange="myimage('2')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/2.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/3.png" id="3" onchange="myimage('3')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/3.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                <input type="radio" name="img_filter" value="public/filters/4.png" id="4" onchange="myimage('4')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/4.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                     <input type="radio" name="img_filter" value="public/filters/5.png" id="5" onchange="myimage('5')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/5.png">
                           
                        </figure>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/6.png" id="6" onchange="myimage('6')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/6.png">
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/7.png" id="7" onchange="myimage('7')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/7.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/8.png" id="8" onchange="myimage('8')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/8.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/9.png" id="9" onchange="myimage('9')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/9.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="img_filter" value="public/filters/10.png" id="10" onchange="myimage('10')">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/10.png">
                           
                        </figure>
                </div>
            </div>
        </div>
        </form>
    </div>
  </div>
  <!-- list of taken pictures -->
  <div class="column is-two-quarter">
    <div class="box">
            <?php if ($count === 0) { ?>
                <p>No Pictures Yet !!</p>
            <?php
            }
            for($i = 0; $i < $count; $i++) {
                ?>
                <form method="POST" action="index.php?page=deleteImg">
                <figure class="image is-5by3">
                        <img src="<?php echo $pics[$i]['img_path']; ?>">
                        <input style="display:hidden" name="delImgId" value="<?php echo $pics[$i]['id']; ?>">
                        <input style="display:hidden" name="delImgName" value="<?php echo $pics[$i]['img_path']; ?>">
                       <!-- <button class="button is-danger" type="submit" name="imgToDelete" onchange="deleteImage('1')">
                            <span class="icon is-small">
                            <i class="fas fa-times"></i>
                            </span>
                        </button> -->
                </figure>
                <div class="box is-centered">
                    <input class="button is-danger"  name="imgToDelete" type="submit" value="Delete" >
                </div>
                
            <div class="block"></div>
            </form>
        <?php }  ?>
               <!-- <input class="button is-danger" type="submit" id="delete" name="imgToDelete" value="Delete"> -->
        <!--  <figure class="image is-square">
            <img src="https://bulma.io/images/placeholders/256x256.png">
            <button class="delete is-large"></button>
        </figure> -->
    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="public/js/snapshot.js"></script>
<script type="text/javascript" src="public/js/tabs.js"></script>