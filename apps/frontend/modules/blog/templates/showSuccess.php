<? if($sf_user->isAuthenticated()): ?>
    <? include_partial('post/addPost', array('noajax' => true, 'tag' => '#'.$blog->getTag(ESC_RAW).' ')) ?>
<? endif; ?>
<h1><? echo $blog->getName() ?></h1>
<?php echo $blog->getDescription(ESC_RAW); ?>
<h3><?php echo $blog->getSynonyms(); ?></h3>
<div id="post_list">
    <? include_partial('post/postList', array('posts' => $blog->getLine($sf_request->getParameter('page')), 'tagStyle' => 'h2')); ?>
</div>
<? include_partial('global/blogLeftMenu', array('blog' => $blog)) ?>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => $blog->getLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' =>url_for('blog/show?name='.$blog->getTag(ESC_RAW)).'/')) ?>

<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/blog?id='.$blog->getId()))?>
<? end_slot() ?>
