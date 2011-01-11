<li>
    <h2><? echo __('Теги ').$user->getUsername() ?></h2>
    <div class="sidebarContent">
        <div id="tagcloud" style="width:243px;">
        </div>
    </div>
</li>
<!--<li>
    <h2><? echo __('Мета') ?></h2>
    &nbsp;<a href="/post/text" style="text-decoration: none"><?echo __("Комиксы, демотиваторы, цитаты")?></a>
    <div class="sidebarContent">
        <div id="metacloud" style="width:243px;">
        </div>
    </div>
</li>-->

<script type="text/javascript">
    $j(function ()
    {
        var tags = [<?echo $user->getTags(ESC_RAW)?>];
        $j("#tagcloud").tagCloud(tags, {maxFontSizeEm: 3, click: function(tag, event)
            {
                window.location.href = "/user/<?echo $user->getUsername()?>/tag/"+tag;
            }});
        var meta = [
            {tag: "<?echo __("Лучшее")?>", count: <?echo Post::getBestLine('count')?>},
            {tag: "<?echo __("Худшее")?>", count: <?echo Post::getWorstLine('count')?>},
            {tag: "<?echo __("Веселое")?>", count: <?echo Post::getMoodLine(1,'count')?>},
            {tag: "<?echo __("Грустное")?>", count: <?echo Post::getMoodLine(-1,'count')?>},
            {tag: "<?echo __("Интересное")?>", count: <?echo Post::getMoodLine(0,'count')?>},
            {tag: "<?echo __("Без тега")?>", count: <?echo Post::getMoodLine(0,'count')?>}
        ];
        $j("#metacloud").tagCloud(meta, {maxFontSizeEm: 3, click: function(tag, event)
            {
                if(tag == "<?echo __("Лучшее")?>")
                window.location.href = "/best";
                else if(tag == "<?echo __("Худшее")?>")
                window.location.href = "/worst";
                else if(tag == "<?echo __("Веселое")?>")
                window.location.href = "/mood/1";
                else if(tag == "<?echo __("Грустное")?>")
                window.location.href = "/mood/-1";
                else if(tag == "<?echo __("Интересное")?>")
                window.location.href = "/mood/0";
                else if(tag == "<?echo __("Без тега")?>")
                window.location.href = "/notag";
            }});
    });
</script>
