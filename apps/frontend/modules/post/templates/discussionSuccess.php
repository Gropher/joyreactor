<p>
    <? include_partial('addPost') ?>
</p>

<h2><? echo __('Обсуждаемое') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => $sf_user->getGuardUser()->getDiscussionLine($sf_request->getParameter('page')), "show_comments" => true)); ?>
</div>
<? include_partial('global/paging', array('pageLen' => sfConfig::get('app_posts_per_page'),
        'itemsCount' => $sf_user->getGuardUser()->getDiscussionLine('count'),
        'pageNo' => $sf_request->getParameter('page'),
        'updateUrl' => url_for('post/discussion').'/')) ?>
<? include_partial('global/myLeftMenu') ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/discussion?username='.$sf_user->getGuardUser()->getUsername()))?>
<? end_slot() ?>