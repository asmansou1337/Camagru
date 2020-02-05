<div class='container'>
<div class='block  has-text-centered'>
    <h1 class="title">Sign Up</h1>
</div>

<form action="index.php?page=signup" method="post" class="form">
<div class="field">
      <p class="control has-icons-left">
        <input class="input" type="text" placeholder="Username" name="username">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
      </p>
    </div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="email" placeholder="Email" name="email">
    <span class="icon is-small is-left">
      <i class="fas fa-envelope"></i>
    </span>
  </p>
</div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="Password" name="password" autocomplete>
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>
<div class="field">
  <p class="control has-icons-left">
    <input class="input" type="password" placeholder="Confirm Your Password" name="confirmPassword" autocomplete>
    <span class="icon is-small is-left">
      <i class="fas fa-lock"></i>
    </span>
  </p>
</div>
<div class="content">
    <a href="index.php?page=login"> Already Have An Account? LOG IN</a>
</div>
<div class="field">
  <p class="control has-text-centered">
  <input class="button is-success is-medium" type="submit" value="Sign Up" name="signUp">
  </p>
</div>
</form>
</div>