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
  <p class="navbar-item title" > Camagru </p>
  

  
  <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div class="navbar-menu" id="navbarMenu">
    <div class="navbar-start">
      <a class="navbar-item" href="index.php?page=home">
        Home
      </a>

      <a class="navbar-item" href="index.php?page=gallery">
        Gallery
      </a>


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
  <?php if ($_SESSION['loggedIn'] === 'yes') {?>
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
  