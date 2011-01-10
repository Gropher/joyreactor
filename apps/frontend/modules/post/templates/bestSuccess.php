<? use_helper('DeltaCount'); ?>
<? slot('menu2') ?>
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "new") > 0):?>
    <?echo link_to(__('Все')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "new").")",'post/new')?>&nbsp;|&nbsp;
  <?else:?>
    <?echo link_to(__('Все'),'post/new')?>&nbsp;|&nbsp;
  <?endif?>
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "index") > 0):?>
    <?echo link_to(__('Хорошее')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "index").")",'post/index')?>&nbsp;|&nbsp;
  <?else:?>
    <?echo link_to(__('Хорошее'),'post/index')?>&nbsp;|&nbsp;
  <?endif?>
  <b><?echo __('Лучшее')?></b><br/>
<? end_slot() ?>


<? if($sf_user->isAuthenticated()): ?>
    <p>
        <? include_partial('addPost') ?>
    </p>
<? endif ?>

<h2><? echo __('Лучшие записи') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getBestLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getBestLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/best').'/')) ?>
