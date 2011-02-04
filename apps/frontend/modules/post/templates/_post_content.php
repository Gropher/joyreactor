<? use_helper('Text', 'Parse'); ?> 
<div>
    <?php include_partial('post/post_tags', array('post' => $post, 'tagStyle' => $tagStyle)); ?>
    <span><? echo $post->getTextParsed(ESC_RAW) ?></span>
    <? foreach($post->getAttributes() as $attr):?>
        <div class="image" >
        <? echo image_tag($attr->getValue(), array('absolute' => true,'id'=> 'postPicture'.$attr->getId(),
            "alt"=>$attr->getComment() . ($post->getFullTagline() && $attr->getComment() ? ',' : '') . $post->getFullTagline(),
            "title"=>str_replace("\n", " ", $attr->getComment()),
            'onload'=> 'var width = 811; if(screen.width == 1024) width=689; if(typeof $j == \'function\' && $j(\'#postPicture'.$attr->getId().'\') && $j(\'#postPicture'.$attr->getId().'\').width() > width)'.
                ' $j(\'#postPicture'.$attr->getId().'\').width(width);')) ?>
        </div>
    <? endforeach ?>
</div>
