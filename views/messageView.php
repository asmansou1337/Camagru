<div class='container'>
<?php if(!empty($message))
   { ?>
<article class="message is-success">
  <div class="message-body">
  <?= $message; ?>
  </div>
</article>
<?php } ?>

<?php if(!empty($errors))
   { ?>
<article class="message is-danger">
  <div class="message-body">
  <?= $errors; ?>
  </div>
</article>
<?php } ?>
</div>