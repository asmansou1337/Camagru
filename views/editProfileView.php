<div class="block"></div>
<div class='box'>
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
    <label class="checkbox">
    <input type="checkbox" name="checkNotification" <?php if($notify === "ON") { ?> checked="checked" <?php }?>>
      &nbsp; &nbsp;Send Notifications Via Email
    </label>
  </div>

<div class="field">
  <p class="control has-text-centered">
  <input class="button is-success is-medium" type="submit" value="Edit" name="editProfile">
  </p>
</div>
</form>
</div>
<div class='box'>
<div class='block  has-text-centered'>
    <h1 class="title">Edit Your Password</h1>
</div>

<form action="index.php?page=editProfile" method="post" class="form">
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="Old Password" name="oldPassword" autocomplete>
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="New Password" name="newPassword" autocomplete>
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="Confirm New Password" name="confirmNewPassword" autocomplete>
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>

<div class="field">
  <p class="control has-text-centered">
  <input class="button is-success is-medium" type="submit" value="Change Password" name="editPassword">
  </p>
</div>
</form>
</div>
