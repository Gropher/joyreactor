<? if($parent): ?>
    <p>
        <? echo __('Пришел ответ на ваш комментарий к').' '.link_to(__('посту'),'post/show?id='.$post->getId(), 'absolute=true').':' ?>
        <? include_partial('post_comment/comment_content', array('comment' => $parent, 'noreply' => true, 'servertime' => true)) ?>
        <? include_partial('post_comment/comment_content', array('comment' => $comment, 'noreply' => true, 'servertime' => true)) ?>
    </p>
<? else: ?>
    <p>
        <? echo __('Пришел ответ на ваш').' '.link_to(__('пост'),'post/show?id='.$post->getId(), 'absolute=true').':' ?>
    </p>
    <? include_partial('post_comment/comment_content', array('comment' => $comment, 'noreply' => true, 'servertime' => true)) ?>
<? endif ?>