<?php use_helper('I18N') ?>
<div class="sf_apply_notice">
<p>
<?php echo(__(<<<EOM
Проверь почту и начинай общаться!.
EOM
)) ?>
</p>
<p>
<?php echo link_to(__("Далее"), sfConfig::get('app_sfApplyPlugin_after', 'post/user')) ?>
</p>
</div>
