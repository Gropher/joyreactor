<?if($post->getBlogs()->count() != 0):?>
  <<?php echo $tagStyle ?> class="taglist">
    <?
      foreach($post->getBlogs() as $blog) {
        $blog_link = link_to($blog->getTag(), 'blog/show?name='.$blog->getTag(ESC_RAW), array("absolute" => "true", "title" => $blog->getName()))." ";
        if($blog->getCount() > 1) {
          $blog_link = "<b>".$blog_link."</b>";
        }
        echo $blog_link;
      }
    ?>
  </<?php echo $tagStyle ?>>
<?endif?>