<?php use_helper('I18N', 'Url') ?>
<?php echo __(<<<EOM
<p>
Вы зарегистрировались на сайте %1%.
</p>
<p>
Чтобы активировать свой аккаунт перейдите по ссылке:
</p>
<p>
%2%
</p>
<p>
Спасибо!
</p>
EOM
, array("%1%" => link_to($sf_request->getHost(), $sf_request->getUriPrefix()),
  "%2%" => link_to(url_for("sfApply/confirm?validate=$validate&partnerId=$partnerId", true), "sfApply/confirm?validate=$validate&partnerId=$partnerId", array("absolute" => true)))) ?>
