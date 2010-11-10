<? if($sf_user->isAuthenticated()):  ?>
<span class="hidden_link" id="hidden_link<? echo $post->getId() ?>">
        <? if(!$sf_user->getGuardUser()->isHidden($post)): ?>
            <? echo link_to_remote(__('скрыть'), array(
            'update' => 'postContainer'.$post->getId(),
            'url' => 'hidden/create?post_id='.$post->getId().'&show_comments='.$show_comments.'&showAddComment='.$showAddComment), array('title' => __('скрыть содержимое поста'))) ?>
        <? else: ?>
            <? echo link_to_remote(__('показать'), array(
            'update' => 'postContainer'.$post->getId(),
            'url' => 'hidden/delete?post_id='.$post->getId().'&show_comments='.$show_comments.'&showAddComment='.$showAddComment), array('title' => __('показать содержимое поста'))) ?>
        <? endif; ?>
</span>
<? endif; ?>