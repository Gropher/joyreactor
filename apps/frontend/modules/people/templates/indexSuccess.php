<? slot('menu2') ?>
    <b><?echo __('Новые')?></b>&nbsp;&nbsp;|&nbsp;&nbsp;<?echo link_to(__('Самые болтливые'),'people/top')?>
<? end_slot() ?>
<div id="user_list">
    <? include_partial('userList', array('users' => sfGuardUser::getList($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' => sfConfig::get('app_users_per_page'),
                                          'itemsCount' => sfGuardUser::getList('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('people/index').'/')) ?>