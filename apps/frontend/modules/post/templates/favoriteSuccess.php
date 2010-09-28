<? use_helper('Javascript', 'Form'); ?>
<? if($sf_user->isAuthenticated() && $user == $sf_user->getGuardUser()): ?>
    <h2><? echo __('Моё избранное') ?></h2>
    <? include_partial('global/myLeftMenu') ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/user?username='.$sf_user->getGuardUser()->getUsername()))?>
    <? end_slot() ?>
<? else: ?>
    <h2><? echo __('Избранное').' '.$user->getUsername()?></h2>
    <? include_partial('global/userLeftMenu', array('user' => $user)) ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/user?username='.$user->getUsername()))?>
    <? end_slot() ?>
<? endif ?>
<br/>
<div id="post_list">
    <? include_partial('postList', array('posts' => $user->getFavoriteLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => $user->getFavoriteLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' => url_for('post/favorite?username='.$user->getUsername()).'/')) ?>