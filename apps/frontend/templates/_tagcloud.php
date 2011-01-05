<li>
    <h2><? echo __('Теги') ?></h2>
    <div class="sidebarContent">
        <div id="tagcloud" style="width:243px;">
          <?php $tags = Blog::getTags(); ?>
          <?php foreach($tags['tags'] as $tag): ?>
            <a href="<?php echo url_for('@tag?name=' . $tag['tag']);?>" class="tagcloudlink" style="font-size: <?php
                // формула из jquery.tagcloud
                echo 1 + 2 * ($tag['count'] - $tags['min']) / ($tags['max'] - $tags['min']);
              ?>em;" >
              <?php echo $tag['tag']; ?>
            </a>
          <?php endforeach ?>
        </div>
        <?php echo link_to('Все тэги', '@list-tags'); ?>
    </div>
</li>
