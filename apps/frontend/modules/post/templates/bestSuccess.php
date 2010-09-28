<? use_helper('Javascript', 'Form'); ?> 
<h2><? echo __('Лучшие записи') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getBestLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getBestLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/best').'/')) ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/best'))?>
<? end_slot() ?>