<? use_helper('Text', 'Parse'); ?> 
<div>
    <?if($post->getBlogs()->count() != 0):?>
    <span style="display:block; color:#666;">
        <?
	foreach($post->getBlogs() as $blog) {
                $blog_link = link_to($blog->getTag(), 'blog/show?name='.$blog->getTag(ESC_RAW), array("absolute" => "true", "title" => $blog->getName()." (".$blog->getCount()." ".__("постов").")"))." ";
                if($blog->getCount() > 1)
                        $blog_link = "<b>".$blog_link."</b>";
                echo $blog_link;
        }
        ?>
    </span>
    <?endif?>
    <?if($post->getText()!= null):?>
        <span><? echo $post->getText(ESC_RAW) ?></span>
    <?endif?>
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
