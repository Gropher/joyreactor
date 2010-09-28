<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<p>
<?php echo __("Спасибо что активировали свой аккаунт! Теперь вы авторизованы на сайте.") ?>
</p>
<p>
<?php echo link_to(__("Далее"), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</p>
</div>
