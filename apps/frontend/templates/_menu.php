<? use_helper('DeltaCount'); ?>
<ul id="navlist">
    <li id="first">
        <a href="#">   </a>
    </li>
    <li<? if($sf_context->getModuleName() == 'post' && in_array($sf_context->getActionName(), array('new', 'index', 'best'))): ?> class="current_page_item"<? endif ?>>
        <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "index") > 0):?>
            <? echo link_to(__('Новое')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "index").")", 'post/index')?>
        <?else:?>
            <? echo link_to(__('Новое'), 'post/index')?>
        <?endif?>
    </li>
    <li <?if($sf_context->getModuleName() == 'post' && $sf_context->getActionName() == 'discussion'): ?> class="current_page_item"<? endif ?>>
        <?if($sf_user->isAuthenticated() && getDeltaCount($sf_user, $sf_user->getGuardUser()->getDiscussionLine('count'), "discussion") > 0):?>
            <? echo link_to(__('Обсуждаемое')." (+".getDeltaCount($sf_user, $sf_user->getGuardUser()->getDiscussionLine('count'), "discussion").")", 'post/discussion')?>
        <?else:?>
            <? echo link_to(__('Обсуждаемое'), 'post/discussion')?>
        <?endif?>
    </li>
    <li<? if($sf_context->getModuleName() == 'people' && ($sf_context->getActionName() == 'index' || $sf_context->getActionName() == 'top')): ?> class="current_page_item"<? endif ?>>
        <? echo link_to(__('Люди'), 'people/index')?>
    </li>
    <li <?if($sf_context->getModuleName() == 'page'): ?> class="current_page_item"<? endif ?>>
        <? echo link_to(__('О проекте'), '@about')?>
    </li>
    <?include_partial("global/login")?>
</ul>
