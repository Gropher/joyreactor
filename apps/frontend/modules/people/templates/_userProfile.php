<? use_helper('UserTime'); ?>
<span>
    <? echo __('Имя и фамилия').':    ' ?>
    <?if($user->getProfile()->getFullname()):?>
        <? echo $user->getProfile()->getFullname() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>

<?if($sf_user->IsAuthenticated() && $sf_user->getGuardUser() == $user):?>
<span>
    <? echo __('E-Mail').':    ' ?>
    <?if($user->getProfile()->getEmail()):?>
        <? echo $user->getProfile()->getEmail() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>
<?endif?>

<span>
    <? echo __('ICQ').':    ' ?>
    <?if($user->getProfile()->getIcq()):?>
        <? echo $user->getProfile()->getIcq() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>

<span>
    <? echo __('Jabber/Google Talk').':    ' ?>
    <?if($user->getProfile()->getJabber()):?>
        <? echo $user->getProfile()->getJabber() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>

<span>
    <? echo __('Живой Журнал').':    ' ?>
    <?if($user->getProfile()->getLjlogin()):?>
        <? echo $user->getProfile()->getLjlogin() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>

<span>
    <? echo __('О себе').':    ' ?>
    <?if($user->getProfile()->getAbout()):?>
        <? echo $user->getProfile()->getAbout() ?>
    <?else:?>
        <i><?echo __('нет данных')?></i>
    <?endif?>
</span>
<br/>

<span>
    <?echo __('С нами с').':    '?>
    <span id="usertime<?echo $user->getId()?>">
        <? echo user_time($user->getCreatedAt()) ?>
    </span>
</span>
<br/>
