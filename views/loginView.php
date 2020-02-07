<div class='container'>
<div class='block  has-text-centered'>
    <h1 class="title">Log In</h1>
</div>

<form action="index.php?page=login" method="post" class="form">
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

<div class="content has-text-right">
    <a href="index.php?page=forgotPassword"> Forgot Your Password?</a>
</div>
<div class="field">
  <p class="control has-text-centered">
  <input class="button is-success is-medium" type="submit" value="LOG IN" name="login">
  </p>
</div>
<div class="content">
    <a href="index.php?page=signup"> Don't Have An Account Yet? Create One Here</a>
</div>
</form>
</div>