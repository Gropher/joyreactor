<? use_helper('Parse', 'I18N'); ?>
<h1 style="font-size: 11px;"><?echo $description?></h1>
<? echo image_tag($attr->getValue(), array(
"alt"=>$attr->getComment(),
"title"=>str_replace("\n", " ", $attr->getComment()),
'id'=> 'postPicture'.$attr->getId(),
'onload'=> 'var width = 811; if(screen.width == 1024) width=689; if(typeof $j == \'function\' && $j(\'#postPicture'.$attr->getId().'\') && $j(\'#postPicture'.$attr->getId().'\').width() > width)'.
' $j(\'#postPicture'.$attr->getId().'\').width(width);')) ?>
<?if($attr->getOrigin()):?>
<br/><noindex><a rel="nofollow" href="<?echo $attr->getOrigin()?>"><?echo __("оригинал")?></a></noindex>
<?endif?>