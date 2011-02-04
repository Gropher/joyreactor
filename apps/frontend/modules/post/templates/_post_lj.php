<? use_helper('Text', 'Parse'); ?>
<div>
    <?php include_partial('post/post_tags', array('post' => $post, 'tagStyle' => 'h1')); ?>
    <span><? echo $post->getTextParsed(ESC_RAW) ?></span>
    <? foreach($post->getAttributes() as $attr):?>
        <div>
            <? echo image_tag($attr->getValue(), 'absolute=true') ?>
        </div>
    <? endforeach ?>
</div>
<?if(isset($showUsername)):?>
    <span>
        <i><?echo link_to($post->getUser()->getUsername(), 'post/user?username='.$post->getUser()->getUsername(), 'absolute=true')?></i>
    </span>
<?endif?>
<div>
    <small>
        <? echo __('запись опубликована ').link_to('joyreactor.ru','post/show?id='.$post->getId(), 'absolute=true') ?>
    </small>
</div>