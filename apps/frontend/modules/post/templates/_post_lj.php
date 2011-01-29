<? use_helper('Text', 'Parse'); ?>
<div>
    <?if($post->getBlogs()->count() != 0):?>
    <span style="display:block; color:#666;">
        <?
        foreach($post->getBlogs() as $blog)
            echo link_to('#'.$blog->getTag(), 'blog/show?name='.$blog->getTag(), array("absolute" => "true", "title" => $blog->getName()))." ";
        ?>
    </span>
    <?endif?>
    <?if($post->getText()!= null):?>
        <span><? echo $post->getText(ESC_RAW) ?></span>
    <?endif?>
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