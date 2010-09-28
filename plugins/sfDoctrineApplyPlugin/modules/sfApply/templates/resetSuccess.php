<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_reset">
<form method="POST" action="<?php echo url_for("sfApply/reset") ?>" name="sf_apply_reset_form" id="sf_apply_reset_form">
<p>
<?php echo __(<<<EOM
Спасибо за подтверждение e-mail. Теперь Вы можете 
изменить пароль
EOM
) ?>
</p>
<ul>
<?php echo $form ?>
<li>
<input type="submit" value="<?php echo __("Изменить пароль") ?>">, или
<?php echo link_to(__('Отмена'), 'sfApply/resetCancel') ?>
</li>
</ul>
</form>
</div>
