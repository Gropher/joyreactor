<? if($sf_user->isAuthenticated()): ?>
    <p>
        <? include_partial('addPost', array('noajax' => true)) ?>
    </p>
<? endif ?>
<? if($sf_user->isAuthenticated() && $user == $sf_user->getGuardUser()): ?>
    <div class="mainheader"><? echo __('Лента') ?></div>
    <? include_partial('global/myLeftMenu') ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/line?username='.$sf_user->getGuardUser()->getUsername()))?>
    <? end_slot() ?>
<? else: ?>
    <div class="mainheader"><? echo __('Лента').' '.$user->getUsername()?></div>
    <? include_partial('global/userLeftMenu', array('user' => $user)) ?>
    <? slot('rsslink') ?>
        <?echo include_partial('rss/link', array('url' => 'rss/line?username='.$user->getUsername()))?>
    <? end_slot() ?>
<? endif ?>
<br/>
<div id="post_list">
    <? include_partial('postList', array('posts' => $user->getPersonalLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => $user->getPersonalLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' => url_for('post/personal?username='.$user->getUsername()).'/')) ?>