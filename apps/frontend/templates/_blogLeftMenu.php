<? slot('leftmenu') ?>
    <li>
        <div class="sideheader"><? echo __('Тег').' "'.$blog->getName().'"'?></div>
        <div class="sidebarContent">
            <?php if($blog->getAvatar()) : ?>
              <img src="<?php echo $blog->getAvatar(); ?>" alt="<?php echo $blog->getName(); ?>" />
           <?php else : ?>
             <img src="/images/default_avatar.jpeg" alt="<?php echo $blog->getName(); ?>" />
            <?php endif ?>
            <p><? echo __('Рейтинг:').' '.$blog->getRating()?></p>
            <p><? echo __('Постов:').' '.$blog->getLine('count')?></p>
            <? include_partial('favorite/blog_link', array('blog' => $blog)) ?>
        </div>
    </li>
    <? include_partial('global/tagcloud') ?>
    <? include_partial('global/onlineUsers') ?>
<? end_slot() ?>