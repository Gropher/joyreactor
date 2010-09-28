<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<p>
<?php echo __("Ваш пароль успешно изменен. Теперь Вы авторизованы на сайте. 
В дальнейшем используйте свой новый пароль для входа на сайт.") ?>
</p>
<p>
<?php echo link_to(__("Далее"), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</p>
</div>
