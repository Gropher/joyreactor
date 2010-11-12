<!--<b><?echo __('Главная')?></b>&nbsp;|&nbsp;<?echo link_to(__('Лучшее'),'post/best')?><br/>-->
<? if(!$sf_user->isAuthenticated()): ?>
    <? include_partial('global/welcome', array('form' => $form)) ?>
<? else: ?>
    <p>
        <? include_partial('addPost', array('noajax' => true)) ?>
    </p>
<? endif ?>
<h2><? echo __('Главная') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/index'))) ?>