<?php echo __(<<<EOM
Вы зарегистрировались на сайте %1%.

Чтобы активировать свой аккаунт перейдите по ссылке:

%2%

Спасибо!
EOM
, array("%1%" => $sf_request->getHost(),
  "%2%" => url_for("sfApply/confirm?validate=$validate", true))) ?>
