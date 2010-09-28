<? use_helper('Text', 'UserTime'); ?>
<div class="user">
    <? include_partial('people/avatar', array('user' => $user)) ?>
    <a <?
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
        }?>
        href="<?echo url_for('post/user?username='.$user->getUsername())?>">
        <?echo $user->getUsername()?>
    </a>
</div>
<?if(!isset($compact) || !$compact):?>
    <?if($user->getIsActive()):?>
        <? include_partial('people/rating', array('user' => $user)) ?>
    <?else:?>
        <i><?echo __('неактивирован')?></i><br/>
    <?endif?>
    <?if($user->getProfile()->getFullname()):?>
        <? echo __('Имя и фамилия').':    '.$user->getProfile()->getFullname() ?><br/>
    <?endif?>
    <?if($user->getProfile()->getIcq()):?>
        <? echo __('ICQ').':    '.$user->getProfile()->getIcq() ?><br/>
    <?endif?>
    <?if($user->getProfile()->getJabber()):?>
        <? echo __('Jabber/Google Talk').':    '.$user->getProfile()->getJabber() ?><br/>
    <?endif?>
    <?if($user->getProfile()->getLjlogin()):?>
        <? echo __('Живой журнал').':    '.$user->getProfile()->getLjlogin() ?><br/>
    <?endif?>
    <?echo __('С нами с').':    '?>
    <span id="usertime<?echo $user->getId()?>">
        <? echo user_time($user->getCreatedAt()) ?>
    </span>
<?else:?>
    <br/>
<?endif?>