<? use_helper('Javascript', 'Form'); ?> 
<!--<?echo link_to(__('Главная'),'post/index')?>&nbsp;|&nbsp;<b><?echo __('Лучшее')?></b></br></br>-->
<h2><? echo __('Записи за ').strftime('%d %B %Y, %A', strtotime($sf_request->getParameter('date'))) ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => $posts)); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => $post_count,
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/date?date='.$sf_request->getParameter('date')).'/')) ?>