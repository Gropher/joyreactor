<li>
    <div class="sideheader"><?echo __('Сейчас на сайте')?></div>
    <div class="sidebarContent">
        <? include_partial('people/userList', array('users' => sfGuardUser::getOnlineList(), 'compact' => true)); ?>
        <br/>
        <?if(sfGuardUser::getOnlineList('count') > sfConfig::get('app_users_per_page')):?>
            <?echo __("Всего пользователей на сайте").": ".sfGuardUser::getOnlineList('count')?>
        <?endif?>
    </div>
</li>