
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
        <div class="container ">
            <div id="Webcam" class="content-tab" style="position: relative; left: 0; top: 0;">
                <video id="video" autoplay style="position: relative; left: 0; top: 0;"></video>
                <div id="canvasvideo" style="position: absolute; top: 0px; left: 0px;"></div>
                <div id="is_video" style="display:none" value="true"></div>
            </div>
            <div id="local" class="content-tab" style="display:none">
                <div class="container">
                    <div class="container" style="margin-bottom: 2rem;">
                        <div class="file is-centered">
                            <label class="file-label">
                                <input class="file-input" name="localImage" type='file' accept="image/*" onchange="readURL(this);" />
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
                                <img id="imgUploaded">
                        </figure>
                        <div id="canvasImage" style="position: absolute; top: 0px; left: 0px;"></div>
                        <div id="is_image" style="display:none" value="false"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 2rem;margin-bottom: 2rem;">
            <input class="button is-large is-fullwidth is-link is-outlined" id="snap" type="submit" value="Take A Picture" onclick="javascript:Shot();" disabled>
        </div>
        
        <div id="canvas"></div>

        <form method="post" name="formWithImage" accept-charset='utf-8'>
            <input id="imgToSend" name="imgToSend" type='hidden'>
        </form>

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
    </div>
  </div>
  <!-- list of taken pictures -->
  <div class="column is-two-quarter">
    <div class="box">
        <?php for($i = 0; $i < $count; $i++) { 
           // echo $pics[$i]['img_path'];
            ?>
            <figure class="image is-5by3">
                    <img src="<?php echo trim($pics[$i]['img_path']); ?>">
                    <button class="delete is-large"></button>
            </figure>
        <div class="block"></div>

       <?php }  ?>
       <form method="post" name="" accept-charset='utf-8'>
            <input id="delete" name="imgToDelete" >
        </form>
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