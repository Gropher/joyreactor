<? use_helper('DeltaCount'); ?>
<? slot('menu2') ?>
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "new") > 0):?>
    <?echo link_to(__('Все')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "new").")",'post/new')?>
  <?else:?>
    <?echo link_to(__('Все'),'post/new')?>
  <?endif?>
  &nbsp;|&nbsp;
  <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "index") > 0):?>
    <?echo link_to(__('Хорошее')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "index").")",'post/index')?>
  <?else:?>
    <?echo link_to(__('Хорошее'),'post/index')?>
  <?endif?>
  &nbsp;|&nbsp;
  <b>
    <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "best") > 0):?>
      <?echo link_to(__('Лучшее')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "best").")",'post/best')?>
    <?else:?>
      <?echo link_to(__('Лучшее'),'post/best')?>
    <?endif?>
  </b>
  <br/>
<? end_slot() ?>


<? if($sf_user->isAuthenticated()): ?>
    <p>
        <? include_partial('addPost') ?>
    </p>
<? endif ?>

<div class="mainheader"><? echo __('Лучшие записи') ?></div>
<div id="post_list">
    <? include_partial('postList', array('posts' => Post::getBestLine($sf_request->getParameter('page')))); ?>
</div>
<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_posts_per_page'),
                                          'itemsCount' => Post::getBestLine('count'),
                                          'pageNo' => $sf_request->getParameter('page'),
                                          'updateUrl' => url_for('post/best').'/')) ?>
