[exception]   <? echo $code.' | '.$text.' | '.$name ?>
[message]     <? echo $message ?>
<? if (isset($traces) && count($traces) > 0): ?>
[stack trace]
<? foreach ($traces as $line): ?>
  <? echo $line ?>

<? endforeach; ?>
<? endif; ?>
[symfony]     v. <? echo SYMFONY_VERSION ?> (symfony-project.org)
[PHP]         v. <? echo PHP_VERSION ?>
