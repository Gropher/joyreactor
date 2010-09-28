<? if($sf_user->isAuthenticated()): ?>
    <span class="favorite_blog_link" id="favorite_blog_link<? echo $blog->getId() ?>">
        <? if($sf_user->getGuardUser()->getFavoriteBlogValue($blog) <= 0): ?>
            <p>
            <? echo link_to_remote(__('добавить в любимые'), array(
                'update' => 'favorite_blog_link'.$blog->getId(),
                'url' => 'favorite/createblog?blog_id='.$blog->getId()."&value=1"), array('title' => __('добавить в любимые - посты с этим тегом всегда будут появляться в вашей персональной ленте'))) ?>
            </p>
        <? endif; ?>
        <? if($sf_user->getGuardUser()->getFavoriteBlogValue($blog) == 1): ?>
            <p>
            <? echo link_to_remote(__('убрать из любимых'), array(
                'update' => 'favorite_blog_link'.$blog->getId(),
                'url' => 'favorite/deleteblog?blog_id='.$blog->getId()), array('title' => __('убрать из любимых - посты с этим тегом иногда будут появляться в вашей персональной ленте'))) ?>
            </p>
        <? endif; ?>
        <? if($sf_user->getGuardUser()->getFavoriteBlogValue($blog) == -1): ?>
            <p>
            <? echo link_to_remote(__('убрать из нелюбимых'), array(
                'update' => 'favorite_blog_link'.$blog->getId(),
                'url' => 'favorite/deleteblog?blog_id='.$blog->getId()), array('title' => __('убрать из нелюбимых - посты с этим тегом иногда будут появляться в вашей персональной ленте'))) ?>
            </p>
        <? endif; ?>
        <? if($sf_user->getGuardUser()->getFavoriteBlogValue($blog) >= 0): ?>
            <p>
            <? echo link_to_remote(__('добавить в нелюбимые'), array(
                'update' => 'favorite_blog_link'.$blog->getId(),
                'url' => 'favorite/createblog?blog_id='.$blog->getId()."&value=-1"), array('title' => __('добавить в нелюбимые - посты с этим тегом никогда не будут появляться в вашей персональной ленте'))) ?>
            </p>
        <? endif; ?>
    </span>
<? endif; ?>