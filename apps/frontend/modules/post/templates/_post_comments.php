<? use_helper('Text', 'Parse', 'UserTime', 'DeltaCount'); ?>
<div id="comment_list<?echo $post->getId()?>_">
    <? include_partial('post_comment/commentList', array('comments' => $post->getComments())) ?>
    <?if($post->getAllComments('count') == 0):?>
        <i><? echo __('нет комментариев') ?></i>
    <?endif?>
</div>
<? if($sf_user->isAuthenticated()): ?>
<div class="add-comment-link">
	<?echo link_to_function(__('Написать комментарий'), '$j(".addcomment").hide("fast");if($j("#addcomment'.$post->getId().'").is(":visible"))$j("#addcomment'.$post->getId().'").hide("fast"); else $j("#addcomment'.$post->getId().'").show("fast")')?>
</div>
<div id='addcomment<?echo $post->getId()?>' <?if(isset($showAddComment) && $showAddComment):?>class='addcommentInline'<?else:?>class='addcomment'<?endif?>>
	<? include_partial('post_comment/addComment', array('post' => $post)) ?>
</div>
<?else:?>
    <? echo __('Только зарегистрированные пользователи могут добавлять комментарии.')?>
<? endif; ?>
<?
if($sf_user->isAuthenticated()) {
    Cookie::setCookie($sf_user->getGuardUser(), "comments".$post->getId(), $post->getAllComments('count'), time() + 24 * 60 * 60);
    Cookie::setCookie($sf_user->getGuardUser(), "comments".$post->getId()."Time", date("Y-m-d H:i:s"), time() + 24 * 60 * 60);
}
?>