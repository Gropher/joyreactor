<?php use_helper('I18N') ?>

<form class="sfSignin" action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
  <ul>
    <?php echo $form ?>
  </ul>

  <input type="submit" value="<?php echo __('Войти') ?>" />
  <a href="<?php echo url_for('@sf_guard_password') ?>"><?php echo __('Забыли пароль?') ?></a>
</form>
