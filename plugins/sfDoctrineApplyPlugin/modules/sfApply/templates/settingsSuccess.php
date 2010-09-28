<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php use_helper("I18N") ?>
<div class="sf_apply sf_apply_settings">
<h2><?php echo __("Настройки аккаунта") ?></h2>
<form method="POST" enctype="multipart/form-data" action="<?php echo url_for("sfApply/settings") ?>" name="sf_apply_settings_form" id="sf_apply_settings_form">
<ul>
<?php echo $form ?>
<li>
    <input type="submit" value="<?php echo __("Сохранить") ?>" />&nbsp; <?php echo(__("или")) ?>&nbsp;
<?php echo link_to(__('Отмена'), "people/show?username=".$sf_user->getGuardUser()->getUsername()) ?>
</li>
</ul>
</form>
<form method="GET" action="<?php echo url_for("sfApply/resetRequest") ?>" name="sf_apply_reset_request" id="sf_apply_reset_request">
<p>
<?php echo __(<<<EOM
Нажмите на эту кнопку, если хотите поменять пароль. По соображениям безопасности, 
Вам будет отправлено письмо, содержащее ссылку для подтверждения изменения пароля. 
EOM
) ?>
</p>
<input type="submit" value="<?php echo __("Изменить пароль") ?>" />
</form>
</div>
