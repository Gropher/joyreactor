<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply_notice">
<?php echo __(<<<EOM
<p>
По соображениям безопасности на ваш e-mail выслано письмо с подтверждением. 
Проверьте почту. Чтобы поменять пароль, Вам нужно перейти по ссылке, содержащейся
в письме. Если Вы не можете найти письмо, посмотрите в папке для нежелательной почты (спама).
</p>
<p>
Извините за задержку.
</p>
EOM
) ?>
<p>
<?php echo link_to(__("Далее"), sfConfig::get('app_sfApplyPlugin_after', '@homepage')) ?>
</p>
</div>
