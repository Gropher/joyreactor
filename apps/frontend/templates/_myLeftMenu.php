<? slot('leftmenu') ?>
<li>
    <div class="sidebarContent">
        <div class="user">
            <? include_partial('people/avatar', array('user' => $sf_user->getGuardUser())) ?>
            <span <?
                if($sf_user->getGuardUser()->isOnline()) {
                    echo 'class="online_username"';
                    if($sf_user->getGuardUser()->getLastStatus() && $sf_user->getGuardUser()->getLastStatus()->getText())
                        echo 'title="'.$sf_user->getGuardUser()->getLastStatus()->getText().'"';
                    else
                        echo 'title="'.__('сейчас на сайте').'"';
                } else {
                    echo 'class="offline_username"';
                    if($sf_user->getGuardUser()->getLastStatus() && $sf_user->getGuardUser()->getLastStatus()->getText())
                        echo 'title="'.$sf_user->getGuardUser()->getLastStatus()->getText().'"';
                }?>>
                <big><? echo $sf_user->getUsername() ?></big>
            </span>
        </div>
        <?if($sf_user->getGuardUser()->getIsActive()):?>
            <? include_partial('people/rating', array('user' => $sf_user->getGuardUser())) ?>
        <?else:?>
        <i title="Вам необходимо активировать свой аккаунт. Воспользуйтесь ссылкой, которая была выслана Вам по e-mail. "><?echo __('неактивен')?></i><br/>
        <small><small><small>
                    <a href="/reactivate/<?echo $sf_user->getUsername()?>">выслать письмо с подтверждением заново</a>
                </small></small></small>
        <?endif?>
                <? echo link_to(__('Мои последние записи'), 'user/'.$sf_user->getGuardUser()->getUsername())?><br/>
        <? echo link_to(__('Новенькое у друзей'), 'post/friends?username='.$sf_user->getGuardUser()->getUsername())?><br/>
        <? echo link_to(__('Мои закладки'), 'post/favorite?username='.$sf_user->getGuardUser()->getUsername())?><br/>
        <? echo link_to(__('Мои настройки'), '@settings')?><br/><br/>
    </div>
</li>
<?if($sf_user->getGuardUser()->getLastStatus() && $sf_user->getGuardUser()->getLastStatus()->getText()):?>
<li>
    <h2><? echo __('Мой статус') ?></h2>
    <div class="sidebarContent">
            <? include_partial('people/status', array('status' => $sf_user->getGuardUser()->getLastStatus())) ?>
    </div>
</li>
<?endif?>
<? include_partial('global/myTagcloud') ?>
<li>
    <h2><?echo __('Мои друзья')?></h2>
    <div class="sidebarContent">
        <? include_partial('people/userList', array('users' => $sf_user->getGuardUser()->getFriendsList(1), 'compact' => true)); ?><br/>
        <?if($sf_user->getGuardUser()->getFriendsList('count') > sfConfig::get('app_users_per_page')) echo '<small>'.link_to(__('Все друзья')."(".$sf_user->getGuardUser()->getFriendsList('count').")</small>", 'people/friends?username='.$sf_user->getGuardUser()->getUsername())?>
    </div>
</li>
<li>
    <h2><?echo __('Мой профиль')?></h2>
    <div class="sidebarContent">
        <? include_partial('people/userProfile', array('user' => $sf_user->getGuardUser())); ?>
        <?if($sf_user->getGuardUser()->getFavoriteBlogsList(1, 'count')):?>
        <div>
                <?echo __("Любимые теги:")?>
                <?foreach($sf_user->getGuardUser()->getFavoriteBlogsList(1) as $blog):?>
            &nbsp;<?echo link_to($blog->getName(), "blog/show?name=".$blog->getTag())?>
                <?endforeach?>
        </div>
        <?endif?>
        <?if($sf_user->getGuardUser()->getFavoriteBlogsList(-1, 'count')):?>
        <div>
                <?echo __("Нелюбимые теги:")?>
                <?foreach($sf_user->getGuardUser()->getFavoriteBlogsList(-1) as $blog):?>
            &nbsp;<?echo link_to($blog->getName(), "blog/show?name=".$blog->getTag())?>
                <?endforeach?>
        </div>
        <?endif?>
        <small><?echo link_to(__('Настроить'), '@settings')?><br/></small>
    </div>
</li>
<? include_partial('global/onlineUsers') ?>
<? include_partial('global/friendConnect') ?>
<? end_slot() ?>