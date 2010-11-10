<? if($sf_user->isAuthenticated() && $user == $sf_user->getGuardUser()): ?>
    <h2><? echo __('Моя френдлента') ?></h2>
    <? include_partial('global/myLeftMenu') ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/friends?username='.$sf_user->getGuardUser()->getUsername()))?>
    <? end_slot() ?>
<? else: ?>
    <h2><? echo __('Френдлента').' '.$user->getUsername()?></h2>
    <? include_partial('global/userLeftMenu', array('user' => $user)) ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/friends?username='.$user->getUsername()))?>
    <? end_slot() ?>
<? endif ?>
<br/>
<div id="post_list">
    <? include_partial('postList', array('posts' => $user->getFriendsLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => $user->getFriendsLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' => url_for('post/friends?username='.$user->getUsername()).'/')) ?>