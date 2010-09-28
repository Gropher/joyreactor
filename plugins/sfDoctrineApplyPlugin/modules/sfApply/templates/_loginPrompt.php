<?php use_helper('I18N') ?>
<form method="POST" action="<?php echo url_for("@sf_guard_signin") ?>" name="sf_guard_signin" id="sf_guard_signin" class="sf_apply_signin_inline">
  <?php echo $form ?>
  <input type="submit" value="<?php echo __('sign in') ?>" />
  <p>
  <?php echo link_to(__('Reset Your Password'), 'sfApply/resetRequest')  ?>
  </p>
  <p>
  <?php
  echo link_to(__('Create a New Account'), 'sfApply/apply')
  ?>
  </p>
</form>
