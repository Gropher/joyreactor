<? if($sf_user->isAuthenticated() && $user == $sf_user->getGuardUser()): ?>
    <h1><? echo __('Мои друзья') ?></h1>
    <? include_partial('global/myLeftMenu') ?>
<? else: ?>
    <h1><? echo __('Друзья').' '.$user->getUsername()?></h1>
    <? include_partial('global/userLeftMenu', array('user' => $user)) ?>
<? endif ?>

<div id="user_list">
    <? include_partial('userList', array('users' => $user->getFriendsList($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' => sfConfig::get('app_users_per_page'),
                                          'itemsCount' => $user->getFriendsList('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('people/friends?username='.$user->getUsername()).'/')) ?>