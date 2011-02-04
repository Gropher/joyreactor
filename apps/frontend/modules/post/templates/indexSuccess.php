<? use_helper('DeltaCount'); ?>
<? slot('menu2') ?>
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "new") > 0):?>
    <?echo link_to(__('Все')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "new").")",'post/new')?>
  <?else:?>
    <?echo link_to(__('Все'),'post/new')?>
  <?endif?>
  &nbsp;|&nbsp;
  <b>
    <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "index") > 0):?>
      <?echo link_to(__('Хорошее')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "index").")",'post/index')?>
    <?else:?>
      <?echo link_to(__('Хорошее'),'post/index')?>
    <?endif?>
  </b>
  &nbsp;|&nbsp;
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "best") > 0):?>
    <?echo link_to(__('Лучшее')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "best").")",'post/best')?>
  <?else:?>
    <?echo link_to(__('Лучшее'),'post/best')?>
  <?endif?>
  <br/>
<? end_slot() ?>

<? if(!$sf_user->isAuthenticated()): ?>
    <? include_partial('global/welcome', array('form' => $form)) ?>
<? else: ?>
    <p>
        <? include_partial('addPost', array('noajax' => true)) ?>
    </p>
<? endif ?>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/index'))) ?>
