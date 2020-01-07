<div class='container'>
<div class='block  has-text-centered'>
    <h1 class="title">Notifications Setting</h1>
</div>

<form action="index.php?page=notifications" method="post" class="form">
  <div class="field has-text-centered">
    <label class="checkbox">
    <input type="checkbox" name="checkNotification" <?php if($notify === "ON") { ?> checked="checked" <?php }?>>
      &nbsp; &nbsp;Send Notifications Via Email
    </label>
  </div>
  <div class="field">
    <p class="control has-text-centered">
    <input class="button is-success is-medium" type="submit" value="Edit Settings" name="editNotifications">
    </p>
  </div>
</form>
</div>