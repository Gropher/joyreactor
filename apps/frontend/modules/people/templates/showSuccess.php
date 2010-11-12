<h1><? echo __('Профиль').' '.$user->getUsername() ?></h1>
<div id="user_profile">
    <? include_partial('userProfile', array('user' => $user)); ?>
</div>
<? include_partial('global/userLeftMenu', array('user' => $user)) ?>