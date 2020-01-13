<script>
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
  }
</script>

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
            <div id="Webcam" class="content-tab" >
                <div class="box">
                    <figure class="image is-5by4">
                        <img src="https://bulma.io/images/placeholders/256x256.png">
                    </figure>
                </div>
            </div>
            <div id="local" class="content-tab" style="display:none">
                <div class="container">
                    <div class="container" style="margin-bottom: 2rem;">
                        <div class="file is-centered">
                            <label class="file-label">
                                <input class="file-input" type="file" name="localImage">
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
                    <div class="box">
                        <figure class="image is-5by4">
                                <img src="https://bulma.io/images/placeholders/256x256.png">
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 2rem;margin-bottom: 2rem;">
            <input class="button is-large is-fullwidth is-link is-outlined" type="submit" value="Take A Picture">
        </div>
        <div class="columns">
            <div class="column">
                <div>
                    <input type="radio" name="filter" value="public/filters/1.png">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/1.png">
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="filter" value="2">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/2.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="filter" value="3">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/3.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="filter" value="4">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/4.png">
                           
                        </figure>
                </div>
            </div>
            <div class="column">
                <div>
                    <input type="radio" name="filter" value="5">
                </div>
                <div class="box">
                        <figure class="image is-square">
                            <img src="public/filters/5.png">
                           
                        </figure>
                </div>
            </div>
        </div>
    </div>
  </div>
  <!-- list of taken pictures -->
  <div class="column is-two-quarter">
    <div class="box">
        <figure class="image is-square">
            <img src="https://bulma.io/images/placeholders/256x256.png">
            <button class="delete is-large"></button>
        </figure>
        <div class="block"></div>
        <figure class="image is-square">
            <img src="https://bulma.io/images/placeholders/256x256.png">
            <button class="delete is-large"></button>
        </figure>
        <div class="block"></div>
        <figure class="image is-square">
            <img src="https://bulma.io/images/placeholders/256x256.png">
            <button class="delete is-large"></button>
        </figure>
    </div>
  </div>
</div>
</div>