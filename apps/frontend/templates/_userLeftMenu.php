<? slot('leftmenu') ?>
    <li>
        <div class="sidebarContent">
            <div class="user">
                <? include_partial('people/avatar', array('user' => $user)) ?>
                <span <?
                    if($user->isOnline()) {
                        echo 'class="online_username"';
                        if($user->getLastStatus() && $user->getLastStatus()->getText())
                            echo 'title="'.$user->getLastStatus()->getText().'"';
                        else
                            echo 'title="'.__('сейчас на сайте').'"';
                    } else {
                        echo 'class="offline_username"';
                        if($user->getLastStatus() && $user->getLastStatus()->getText())
                            echo 'title="'.$user->getLastStatus()->getText().'"';
                    }?>>
                    <big><? echo $user->getUsername() ?></big>
                </span>
            </div>
            <? include_partial('people/rating', array('user' => $user)) ?>
            <? if($sf_user->isAuthenticated()): ?>
                <? include_partial('friend/link', array('user' => $user)) ?><br/>
            <? endif ?>
            <? echo link_to(__('Последние записи '), 'post/user?username='.$user->getUsername())?><br/>
            <? echo link_to(__('Новенькое у друзей'), 'post/friends?username='.$user->getUsername())?><br/>
            <? echo link_to(__('Закладки'), 'post/favorite?username='.$user->getUsername())?><br/><br/>
        </div>
    </li>
    <?if($user->getLastStatus() && $user->getLastStatus()->getText()):?>
    <li>
        <h2><? echo __('Cтатус ').$user->getUsername() ?></h2>
        <div class="sidebarContent">
            <? include_partial('people/status', array('status' => $user->getLastStatus())) ?>
        </div>
    </li>
    <?endif?>
    <? include_partial('global/userTagcloud', array('user'=> $user)) ?>
    <li>
        <h2><?echo __('Друзья ').$user->getUsername()?></h2>
        <div class="sidebarContent">
            <? include_partial('people/userList', array('users' => $user->getFriendsList(1), 'compact' => true)); ?><br/>
            <?if($user->getFriendsList('count') > sfConfig::get('app_users_per_page')) echo link_to(__('Все друзья')."(".$user->getFriendsList('count').")", 'people/friends?username='.$user->getUsername())?>
        </div>
    </li>
    <li>
        <h2><?echo __('Профиль ').$user->getUsername()?></h2>
        <div class="sidebarContent">
            <? include_partial('people/userProfile', array('user' => $user)); ?>
        </div>
    </li>
    <? include_partial('global/onlineUsers') ?>
    <? include_partial('global/friendConnect') ?>
<? end_slot() ?>
