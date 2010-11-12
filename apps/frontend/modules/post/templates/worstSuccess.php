<h2><? echo __('Худшие записи') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getWorstLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getWorstLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/worst').'/')) ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/worst'))?>
<? end_slot() ?>