<li>
    <div class="sideheader"><? echo __('Теги ').$user->getUsername() ?></div>
    <div class="sidebarContent">
        <div id="tagcloud" style="width:243px;">
        </div>
    </div>
</li>

<script type="text/javascript">
    $j(function ()
    {
        var tags = [<?echo $user->getTags(ESC_RAW)?>];
        $j("#tagcloud").tagCloud(tags, {maxFontSizeEm: 3, click: function(tag, event)
            {
                window.location.href = "/user/<?echo $user->getUsername()?>/tag/"+tag;
            }});
    });
</script>
