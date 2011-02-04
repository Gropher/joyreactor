<li>
    <div class="sideheader"><? echo __('Мои теги')?></div>
    <div class="sidebarContent">
        <div id="tagcloud" style="width:243px;height:200px;">
        </div>
    </div>
</li>
<li>
<script type="text/javascript">
    $j(function ()
    {
        var tags = [<?echo $sf_user->getGuardUser()->getTags(ESC_RAW)?>];
        $j("#tagcloud").tagCloud(tags, {maxFontSizeEm: 3, click: function(tag, event)
            {
                window.location.href = "/user/<?echo $sf_user->getGuardUser()->getUsername()?>/tag/"+tag;
            }});
    });
</script>
