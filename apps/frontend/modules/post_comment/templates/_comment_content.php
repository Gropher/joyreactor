<? use_helper('Text', 'Parse'); ?> 
<div id="comment<? echo $comment->getId() ?>">
        <nobr><? echo $comment->getCreatedAt().' GMT' ?></nobr>
    <? echo link_to($comment->getUser()->getUsername().':', 'user/'.$comment->getUser()->getUsername(),'absolute=true') ?>
    <? echo $comment->getCommentParsed(ESC_RAW) ?>
</div>