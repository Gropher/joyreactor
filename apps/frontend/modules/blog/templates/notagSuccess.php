<h2><? echo __("Записи без тега") ?></h2>
<div id="post_list">
    <? include_partial('post/postList', array('posts' => Blog::getNoBlogLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => Blog::getNoBlogLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' => url_for('blog/notag').'/')) ?>