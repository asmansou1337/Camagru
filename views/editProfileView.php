<div class='container'>
<div class='block  has-text-centered'>
    <h1 class="title">Edit Your Profile</h1>
</div>
<form action="index.php?page=editProfile" method="post" class="form">
<div class="field">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Username" name="username" value="<?php echo (isset($_SESSION['user']) ? unserialize($_SESSION['user'])->getUsername() : ''); ?>">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="First Name" name="firstName" value="<?php echo (isset($_SESSION['user']) ? unserialize($_SESSION['user'])->getFirstName() : ''); ?>">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Last Name" name="lastName" value="<?php echo (isset($_SESSION['user']) ? unserialize($_SESSION['user'])->getLastName() : ''); ?>">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
      </p>
    </div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="email" placeholder="Email" name="email" value="<?php echo (isset($_SESSION['user']) ? unserialize($_SESSION['user'])->getEmail() : ''); ?>">
    <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
  </p>
</div>

<div class="field">
  <p class="control has-text-centered">
  <input class="button is-success is-medium" type="submit" value="Edit" name="editProfile">
  </p>
</div>
</form>
</div>