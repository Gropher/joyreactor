<h2><? echo __('Комиксы, демотиваторы, цитаты') ?></h2>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page') * 5,
                                          'itemsCount' => Post::getTextLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/text').'/',
                                          'numEdgeEntries' => 50,
                                          'numDisplayEntries' => 100)) ?>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getTextLine($sf_request->getParameter('page')))); ?>
</div>
