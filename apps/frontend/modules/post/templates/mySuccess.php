<p>
	<? include_partial('addPost', array('mypage' => true)) ?>
</p>

<h2><? echo __('Мои записи') ?></h2>
<div id="post_list">
    <? include_partial('postList', array('posts' => $sf_user->getGuardUser()->getLine($sf_request->getParameter('page')))); ?>
    <?if($sf_user->isAuthenticated() && $sf_user->getGuardUser()->getProfile()->getRating()==0):?>
        <div> 
            <div class="article post-good">
                <div class="content">
                    <h3><?echo image_tag("/images/smile_good.png",array('width'=>46)).' '.__("Привет!")?></h3>
                    <?echo __("Мы рады тебя видеть =) Проверь почту, если ты этого еще не сделал. Туда будет сыпаться все твое общение.")?><br/>
                    <p><b><?echo __("Теперь ты можешь")?>:</b></p>
                    <ol>
                        <li style="margin-left:20px; list-style-type:decimal;"><p><?echo link_to(__("Почитать"), "post/new")." ".__("что пишет народ, покомментировать. Настроение поднимется гарантированно!")?></p></li>
                        <li style="margin-left:20px; list-style-type:decimal;"><p><?echo __("Рассказать нам, как у тебя дела и как у тебя настроение. Нам правда интересно!")?></p></li>
                    </ol>
                </div>
            </div>
        </div>
    <?endif?>
</div>
    <? include_partial('global/paging', array('pageLen' => sfConfig::get('app_posts_per_page'),
                                              'itemsCount' => $sf_user->getGuardUser()->getLine('count'),
                                              'pageNo' => $sf_request->getParameter('page'),
                                              'updateUrl' => url_for('post/user?username='.$sf_user->getGuardUser()->getUsername()).'/')) ?>
<? include_partial('global/myLeftMenu') ?>
<? slot('rsslink') ?>
    <?echo include_partial('rss/link', array('url' => 'rss/user?username='.$sf_user->getGuardUser()->getUsername()))?>
<? end_slot() ?>