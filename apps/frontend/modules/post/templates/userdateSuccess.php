<div class="mainheader"><? echo __('Записи').' '.$user->getUsername().' '.__('за').' '.strftime('%d %B %Y, %A', strtotime($sf_request->getParameter('date'))) ?></div>
<div id="post_list">
    <? include_partial('postList', array('posts' => $posts)); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => $post_count,
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/userdate?username='.$user->getUsername().'&date='.$sf_request->getParameter('date')).'/')) ?>
<? include_partial('global/userLeftMenu', array('user' => $user)) ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/user?username='.$user->getUsername()))?>
<? end_slot() ?>