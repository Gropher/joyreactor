<div class="mainheader"><? echo __('Профиль').' '.$user->getUsername() ?></div>
<div id="user_profile">
    <? include_partial('userProfile', array('user' => $user)); ?>
</div>
<? include_partial('global/userLeftMenu', array('user' => $user)) ?>