<h2><? echo $blog->getName() ?> / <? echo $user->getUsername()?></h2>
<div id="post_list">
    <? include_partial('post/postList', array('posts' => $blog->getUserLine($user, $sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/blogLeftMenu', array('blog' => $blog)) ?>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                            'itemsCount' => $blog->getLine('count'),
                                            'pageNo' => $sf_request->getParameter('page'),
                                            'updateUrl' => url_for('blog/user?name='.$blog->getTag(ESC_RAW)."&username=".$user->getUsername()).'/')) ?>

<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => url_for('rss/userblog?id='.$blog->getId()."&username=".$user->getUsername())))?>
<? end_slot() ?>
