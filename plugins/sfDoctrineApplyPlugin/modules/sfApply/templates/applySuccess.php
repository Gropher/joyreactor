<?php use_helper('I18N') ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_apply">
<h2><?php echo __("Регистрация") ?></h2>
<form method="POST" action="<?php echo url_for('sfApply/apply?partnerId='.$partnerId) ?>"
  name="sf_apply_apply_form" id="sf_apply_apply_form">
<ul>
<?php echo $form ?>
<li><small><p><?echo __("*Для того, чтобы общаться, надо указать свою настоящую почту.")?></p></small></li>
<li class="sf_apply_submit_row">
<p>
    <input type="submit" value="<?php echo __("Зарегистрироваться") ?>" />
    <?php echo __("или") ?>
    <?php echo link_to(__("Отмена"), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</p>
</li>
</ul>
</form>
</div>
