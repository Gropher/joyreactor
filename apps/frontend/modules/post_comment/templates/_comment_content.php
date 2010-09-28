<? use_helper('Javascript', 'Text', 'Parse'); ?> 
<div id="comment<? echo $comment->getId() ?>">
        <nobr><? echo $comment->getCreatedAt().' GMT' ?></nobr>
    <? echo link_to($comment->getUser()->getUsername().':', 'user/'.$comment->getUser()->getUsername(),'absolute=true') ?>
    <? echo auto_link_text(parsetext(nl2br($comment->getComment(ESC_RAW)))) ?>
</div>