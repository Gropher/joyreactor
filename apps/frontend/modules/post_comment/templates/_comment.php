<? use_helper('Javascript', 'Text', 'Parse', 'UserTime', 'DeltaCount'); ?>
<div name="comment<? echo $comment->getId() ?>" id="comment<? echo $comment->getId() ?>" class="comment <?if(isNew($sf_user, $comment->getCreatedAt(), "comments".$comment->getPost()->getId()."Time")) echo ' commentnew'?>">
    <? if(!isset($level)) $level = 0; ?>
    <div class="avatar"><img src="/images/comments.gif" title="<? echo user_time($comment->getCreatedAt()) ?>" /></div>
    <div class="txt">
        <? echo parsetext($comment->getComment(ESC_RAW)) ?>&nbsp;&mdash;
        <span>
            <a <?if($comment->getUser()->isOnline()) {
                    echo 'class="online_username" ';
                    if($comment->getUser()->getLastStatus() && $comment->getUser()->getLastStatus()->getText())
                        echo 'title="'.$comment->getUser()->getLastStatus()->getText().'"';
                    else
                        echo 'title="'.__('сейчас на сайте').'"';
                 } else {
                    echo 'class="offline_username"';
                    if($comment->getUser()->getLastStatus() && $comment->getUser()->getLastStatus()->getText())
                        echo 'title="'.$comment->getUser()->getLastStatus()->getText().'"';
                 }?>
                href="<?echo url_for('post/user?username='.$comment->getUser()->getUsername())?>"><?echo $comment->getUser()->getUsername()?></a>
        </span>
        <span class="reply-link">
            <a href="<?echo url_for("post/show?id=".$comment->getPost()->getId()."#comment".$comment->getId())?>"><?echo __("ссылка")?></a>
        </span>
        <? if($sf_user->isAuthenticated()): ?>
            <? if(!isset($noreply) || !$noreply): ?>
                <? if($sf_user->isAuthenticated()): ?>
                    <span class="reply-link">
                        <? if($sf_user->getGuardUser() == $comment->getPost()->getUser() || $sf_user->getGuardUser() == $comment->getUser()): ?>
                            <? echo link_to('удалить', 'post_comment/delete?id='.$comment->getId(), array('title' => __('удалить комментарий'), 'class'=>"delete", 'onclick' => "return confirm('".__('Действительно удалить комментарий?')."')")) ?>
                        <? endif ?>
                        <? echo link_to_function(__('ответить↓'), '$j(".addcomment").hide("fast");if($j("#comment_reply'.$comment->getId().'").is(":visible"))$j("#comment_reply'.$comment->getId().'").hide("fast"); else $j("#comment_reply'.$comment->getId().'").show("fast")') ?>
                    </span>
                    <div id="comment_reply<? echo $comment->getId() ?>" class='addcomment'>
                        <? include_partial('post_comment/addComment', array('post' => $comment->getPost(), 'parent' => $comment)) ?>
                    </div>
                <? endif ?>
            <? endif ?>
        <? endif ?>
    </div>
</div>
<div id="comment_list<?echo $comment->getPost()->getId()."_".$comment->getId()?>" style="margin-left:<? echo  ($level+1)*20?>px;">
    <? include_partial('post_comment/commentList', array('comments' => $comment->getComments(), 'level' => $level+1)) ?>
</div>
<script type="text/javascript">
$j(function(){
    $j(".comment").hover(
    function(){
        $j(this).css("background","#ebebeb");
    },
    function(){
        $j(this).css("background","none");
    }
);});
</script>