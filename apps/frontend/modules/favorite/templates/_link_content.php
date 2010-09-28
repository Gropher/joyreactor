<? if($sf_user->isAuthenticated()): ?>
    <span class="favorite_link" id="favorite_link<? echo $post->getId() ?>">
        <? if($sf_user->getGuardUser()->isFavorite($post)): ?>
            <? echo link_to_remote(__('<img src="/images/favorite.png"/>'), array(
                'update' => 'favorite_link'.$post->getId(),
                'url' => 'favorite/delete?post_id='.$post->getId()), array('title' => __('удалить из избранного'))) ?>
        <? else: ?>
            <? echo link_to_remote(__('<img src="/images/notfavorite.png"/>'), array(
                'update' => 'favorite_link'.$post->getId(),
                'url' => 'favorite/create?post_id='.$post->getId()), array('title' => __('добавить в избранное'))) ?>
        <? endif; ?>
    </span>
<? endif; ?>