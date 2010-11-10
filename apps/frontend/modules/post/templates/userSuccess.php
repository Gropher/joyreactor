<h2><? echo __('Записи').' '.$user->getUsername()?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => $user->getLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' => sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => $user->getLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/user?username='.$user->getUsername()).'/')) ?>
<? include_partial('global/userLeftMenu', array('user' => $user)) ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/user?username='.$user->getUsername()))?>
<? end_slot() ?>