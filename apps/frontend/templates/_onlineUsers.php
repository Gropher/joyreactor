<li>
    <h2><?echo __('Сейчас на сайте')?></h2>
    <div class="sidebarContent">
        <? include_partial('people/userList', array('users' => sfGuardUser::getOnlineList(), 'compact' => true)); ?>
        <br/>
        <?if(sfGuardUser::getOnlineList('count') > sfConfig::get('app_users_per_page')):?>
            <?echo __("Всего пользователей на сайте").": ".sfGuardUser::getOnlineList('count')?>
        <?endif?>
    </div>
</li>