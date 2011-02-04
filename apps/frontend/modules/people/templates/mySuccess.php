<div class="mainheader"><? echo __('Мой профиль') ?></div>
<div id="user_profile">
    <? include_partial('userProfile', array('user' => $user)); ?>
</div>
<? echo link_to(__('Настроить профиль'), '@settings')?>
<? include_partial('global/myLeftMenu') ?>