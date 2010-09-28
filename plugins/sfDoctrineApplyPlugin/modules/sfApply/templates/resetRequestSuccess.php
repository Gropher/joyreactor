<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_reset_request">
<form method="POST" action="<?php echo url_for('sfApply/resetRequest') ?>"
  name="sf_apply_reset_request" "id" = "sf_apply_reset_request">
<p>
<?php echo __(<<<EOM
Забыли пароль? Не проблема! Просто введите свой логин
и нажмите "Изменить пароль." Ссылка для изменения пароля будет выслана Вам по почте.
EOM
) ?>
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Изменить пароль") ?>">, или 
<?php echo link_to(__('Отмена'), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</li>
</ul>
</form>
</div>
