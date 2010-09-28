<? use_helper('DeltaCount'); ?>
<ul id="navlist">
    <li id="first">
        <a href="#">   </a>
    </li>
    <li<? if($sf_context->getModuleName() == 'post' && $sf_context->getActionName() == 'new'): ?> class="current_page_item"<? endif ?>>
        <?if(getDeltaCount($sf_user, Post::getNewLine('count'), "new") > 0):?>
            <? echo link_to(__('Новое')." (+".getDeltaCount($sf_user, Post::getNewLine('count'), "new").")", 'post/new')?>
        <?else:?>
            <? echo link_to(__('Новое'), 'post/new')?>
        <?endif?>
    </li>
    <? if($sf_user->isAuthenticated()): ?>
    <li<? if($sf_context->getModuleName() == 'post' && $sf_context->getActionName() == 'personal'): ?> class="current_page_item"<? endif ?>>
            <?if(getDeltaCount($sf_user, $sf_user->getGuardUser()->getPersonalLine('count'), "personal".$sf_user->getGuardUser()->getId()) > 0):?>
                <? echo link_to(__('Лента')." (+".getDeltaCount($sf_user, $sf_user->getGuardUser()->getPersonalLine('count'), "personal".$sf_user->getGuardUser()->getId()).")", 'post/personal?username='.$sf_user->getGuardUser()->getUsername())?>
            <?else:?>
                <? echo link_to(__('Лента'), 'post/personal?username='.$sf_user->getGuardUser()->getUsername())?>
            <?endif?>
    </li>
    <? else: ?>
    <li<? if($sf_context->getModuleName() == 'post' && $sf_context->getActionName() == 'index'): ?> class="current_page_item"<? endif ?>><? echo link_to(__('Интересное'), 'post/index')?></li>
    <? endif ?>
    <? if($sf_user->isAuthenticated()): ?>
        <li <?if($sf_context->getModuleName() == 'post' && $sf_context->getActionName() == 'discussion'): ?> class="current_page_item"<? endif ?>>
            <?if(getDeltaCount($sf_user, $sf_user->getGuardUser()->getDiscussionLine('count'), "discussion") > 0):?>
                <? echo link_to(__('Обсуждаемое')." (+".getDeltaCount($sf_user, $sf_user->getGuardUser()->getDiscussionLine('count'), "discussion").")", 'post/discussion')?>
            <?else:?>
                <? echo link_to(__('Обсуждаемое'), 'post/discussion')?>
            <?endif?>
        </li>
    <? endif ?>
    <li<? if($sf_context->getModuleName() == 'people' && ($sf_context->getActionName() == 'index' || $sf_context->getActionName() == 'top')): ?> class="current_page_item"<? endif ?>>
        <? echo link_to(__('Люди'), 'people/index')?>
    </li>
    <li <?if($sf_context->getModuleName() == 'page'): ?> class="current_page_item"<? endif ?>>
        <? echo link_to(__('О проекте'), '@about')?>
    </li>
    <?include_partial("global/login")?>
</ul>