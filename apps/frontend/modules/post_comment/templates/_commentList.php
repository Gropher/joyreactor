<? use_helper('Text', 'Parse'); ?>
<? if($comments): ?>
    <? foreach ($comments as $comment): ?>
        <? include_partial('post_comment/comment', array('comment' => $comment)) ?>
    <? endforeach; ?>
<? else: ?>
	<i><? echo __('нет комментариев') ?></i>
<? endif; ?>