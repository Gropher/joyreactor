<? slot('leftmenu') ?>
    <li>
        <h2><? echo __('Тег').' "'.$blog->getName().'"'?></h2>
        <div class="sidebarContent">
            <p><? echo __('Рейтинг:').' '.$blog->getRating()?></p>
            <p><? echo __('Постов:').' '.$blog->getLine('count')?></p>
            <? include_partial('favorite/blog_link', array('blog' => $blog)) ?>
        </div>
    </li>
    <li>
        <h2><? echo __('Пульс настроения сайта') ?></h2>
        <div class="sidebarContent">
            <? include_partial('global/joyPlot', array('joyplot' => Post::getJoyPlot())) ?>
            &nbsp;&nbsp;&nbsp;<small><small><span><?echo __('Настроение сайта сегодня').': <i>'.Post::getTodayMood().'</i>'?></span></small></small>
        </div>
    </li>
    <? include_partial('global/tagcloud') ?>
    <? include_partial('global/onlineUsers') ?>
<? end_slot() ?>