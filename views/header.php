<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title;?> </title>
</head>
<body class='main'>

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
        <a class="fa button is-black is-outlined" href="index.php?page=home">
          <span class="icon">
              <i class="fa-home"></i>
          </span>
          <span>Home</span>
        </a>
      </span>

      <span class="navbar-item">
        <a class="fa button is-black is-outlined" href="index.php?page=gallery&nbr=1">
          <span class="icon">
              <i class="fa-images"></i>
          </span>
          <span>Gallery</span>
        </a>
      </span>

      <?php if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === 'yes') {?>
        <span class="navbar-item">
      <a class="fa button is-black is-outlined" href="index.php?page=upload">
        <span class="icon">
            <i class="fa-download"></i>
        </span>
        <span>Upload</span>
      </a>
    </span>
    </div>
    <div class="navbar-end">
      <div class="navbar-item">
      <button class="button is-outlined "><strong> Welcome &nbsp; <?php echo (isset($_SESSION['user']) ? unserialize($_SESSION['user'])->getUsername() : ''); ?> </strong></button>
      </div>
      <div class="navbar-item">
          <a class="button is-black is-outlined" href="index.php?page=editProfile">
            Edit Profile
          </a>
      </div>
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

  