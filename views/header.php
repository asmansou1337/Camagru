<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title;?> </title>
</head>
<body class='main'>
<script>
  document.addEventListener('DOMContentLoaded', () => {

// Get all "navbar-burger" elements
const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

// Check if there are any navbar burgers
if ($navbarBurgers.length > 0) {

  // Add a click event on each of them
  $navbarBurgers.forEach( el => {
    el.addEventListener('click', () => {

      // Get the target from the "data-target" attribute
      const target = el.dataset.target;
      const $target = document.getElementById(target);

      // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
      el.classList.toggle('is-active');
      $target.classList.toggle('is-active');

    });
  });
}

});
</script>
<!-- Fixed navbar -->
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
  <figure class="image is-128x128">
  <img class="navbar-item"  src="public/images/Camagru.png" alt="camagru">
  </figure>
  
   <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a> 
  </div>

  <div class="navbar-menu" id="navbarMenu">
    <div class="navbar-start">
    <span class="navbar-item">
      <a class="button is-black is-outlined" href="index.php?page=home">
        <span class="icon">
            <i class="fa fa-home"></i>
        </span>
        <span>Home</span>
      </a>
    </span>

    <span class="navbar-item">
      <a class="button is-black is-outlined" href="index.php?page=gallery">
        <span class="icon">
            <i class="fa fa-images"></i>
        </span>
        <span>Gallery</span>
      </a>
    </span>

      <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === 'yes') {?>
        <span class="navbar-item">
      <a class="button is-black is-outlined" href="index.php?page=upload">
        <span class="icon">
            <i class="fa fa-download"></i>
        </span>
        <span>Upload</span>
      </a>
    </span>


     <!-- <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item">
            About
          </a>
          <a class="navbar-item">
            Jobs
          </a>
          <a class="navbar-item">
            Contact
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            Report an issue
          </a>
        </div>
      </div> -->
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-light" href="index.php?page=logout">
            Log out
          </a>
        </div>
      </div>
    </div>
<?php } else {?>
  </div>
    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-primary" href="index.php?page=signup">
            <strong>Sign up</strong>
          </a>
          <a class="button is-light" href="index.php?page=login">
            Log in
          </a>
        </div>
      </div>
    </div>
<?php }?>
  </div>
</nav>

    <!-- Begin page content -->
    <div class="section">




 <!-- <div class="section">
    <div class="container">
      <h1 class="title">
        Hello World
      </h1>
      <p class="subtitle">
        My first website with <strong>Bulma</strong>!
      </p>
    </div>
  </div> -->
  