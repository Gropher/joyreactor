<? slot('menu2') ?>
    <?echo link_to(__('Новые'),'people/index')?>&nbsp;&nbsp;|&nbsp;&nbsp;<b><?echo link_to(__('Самые болтливые'),'people/top')?></b>
<? end_slot() ?>
<div id="user_list">
    <? include_partial('userList', array('users' => sfGuardUser::getTopList($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' => sfConfig::get('app_users_per_page'),
                                          'itemsCount' => sfGuardUser::getTopList('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('people/top').'/')) ?>
