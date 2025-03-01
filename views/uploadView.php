
<div class='container'>
<div class="columns">
  <div class="column is-three-quarters">
    <div class="box is-centered">
        <!-- tabs content (Webcam + upload from computer)-->
        <div class="tabs is-centered is-boxed">
            <ul>
                <li class="tab is-active" onclick="openTab(event,'Webcam')" >
                <a>
                    <span class="icon is-small"><i class="fas fa-camera" aria-hidden="true"></i></span>
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
        <!-- Form to send background image + filter image -->
        <form method="post" name="formWithImage" enctype="multipart/form-data" action="index.php?page=uploadMergeImg">
                <div class="container">
                    <!-- Content showing when webcam tab is showing -->
                    <div id="Webcam" class="content-tab" style="position: relative; left: 0; top: 0;">
                        <video id="video" autoplay style="position: relative; left: 0; top: 0;"></video>
                        <div id="is_video" style="display:none"></div>
                    </div>
                    <!-- Content showing when upload tab is showing -->
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
                            <!-- box showing the uploaded image-->
                            <div class="box" id="imgUploadedBox" style="display:none; position: relative; left: 0; top: 0;">
                                <figure class="image">
                                        <img id="imgUploaded" name="imgUploaded" style="position: relative; left: 0; top: 0;">
                                        <input type="hidden" name="filterwidth" id="filterwidth">
                                        <input type="hidden" name="filterheight" id="filterheight">
                                        <input type="hidden" name="filterpp" id="filterpp">
                                </figure>
                                <div id="is_image" style="display:none"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block"></div>
                <div class="block" style="display:none;" id="infoblock">
                        <div class="field" >
                            <input type="text" class="input is-primary" name="title" id="title" placeholder="Enter Title ..." value="">
                        </div>
                        <div class="field">
                            <div class="control">
                                <input type="textarea" class="textarea is-primary" name="description" id="description" placeholder="Enter Description ..." value=""></textarea>
                            </div>
                        </div>
                        </div>
                <div class="card" style="margin-top: 2rem;margin-bottom: 2rem;">
                    <input class="button is-large is-fullwidth is-link is-outlined" name="submit" id="snap" type="submit" value="Take A Picture" disabled onclick="takeShot();">
                </div>
                <!-- the final background image sended to server -->
                
                    <input id="imgToSend" name="imgToSend" type='hidden'>
        <!-- List of filters -->
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
                </figure>
                <div class="box is-centered">
                    <input class="button is-danger"  name="imgToDelete" type="submit" value="Delete" >
                </div>
                
            <div class="block"></div>
            </form>
        <?php }  ?>
    </div>
  </div>
</div>
</div>

<script type="text/javascript" src="public/js/snapshot.js"></script>
<script type="text/javascript" src="public/js/tabs.js"></script>