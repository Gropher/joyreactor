<? if($sf_user->isAuthenticated()): ?>
    <p>
        <? include_partial('addPost') ?>
    </p>
<? endif ?>
<h2><? echo __('Новые записи') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getNewLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getNewLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/new').'/')) ?>