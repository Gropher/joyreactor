<h2><? echo $title ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getMoodLine($sf_request->getParameter('mood'), $sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getMoodLine($sf_request->getParameter('mood'), 'count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/mood?mood='.$sf_request->getParameter('mood')).'/')) ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/mood?mood='.$sf_request->getParameter('mood')))?>
<? end_slot() ?>