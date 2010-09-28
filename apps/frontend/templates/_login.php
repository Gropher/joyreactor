<? if (has_slot('sf_apply_login')): ?>
    <? include_slot('sf_apply_login') ?>
<? endif ?>
<? if ($sf_user->isAuthenticated()): ?>
    <? include_partial('global/logoutPrompt') ?>
<? else: ?>
    <? include_partial('global/loginPrompt') ?>
<? endif ?>