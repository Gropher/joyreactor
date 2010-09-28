<?php use_helper('I18N') ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_apply">
<h2><?php echo __("Реактивация аккаунта") ?></h2>
<p>
    <?php echo __("неверное имя пользователя") ?>
</p>
</div>
