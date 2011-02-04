<li>
    <div class="sideheader"><? echo __('Теги') ?></div>
    <div class="sidebarContent">
        <div id="tagcloud" style="width:243px;">
          <?php $tags = Blog::getTags(); ?>
          <?php foreach($tags['tags'] as $tag): ?>
          <h2><a href="<?php echo url_for('@tag?name=' . $tag['tag']);?>" class="tagcloudlink" style="font-size: <?php
                // формула из jquery.tagcloud
                echo 1 + 2 * ($tag['count'] - $tags['min']) / ($tags['max'] - $tags['min']);
              ?>em;" >
              <?php echo $tag['tag']; ?>
            </a></h2>
          <?php endforeach ?>
        </div>
        <?php echo link_to('Все тэги', '@list-tags'); ?>
    </div>
</li>
