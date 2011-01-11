<div id="joyplot" style="width:243px;height:200px;"></div>
<?if(!isset($dateFilterUrl)) $dateFilterUrl="/date/"?>
<script>
$j(function ()
{
    var d1 = <? echo $joyplot ?>;
    $j.plot($j("#joyplot"), [ d1 ], {
       xaxis: {
         mode: "time",
         timeformat: "%d %b",
         monthNames: ["янв", "фев", "мар", "апр", "май", "июн", "июл", "авг", "сен", "окт", "ноя", "дек"]
       },
       yaxis:{
         ticks:[[0, ':)'],[-1, ':('],[1, ':D']],
         min: -1, max: 1
       },
       lines: { show: true, fill: false},
       points: { show: true, fill: true },
       grid: 
       {
           autoHighlight: true,
           hoverable: true,
           clickable: true,
           crosshair:{mode: "xy", color: "#333"}
       }
    });
    $j("#joyplot").bind("plotclick", function (event, pos, item) {
        if (item) {
             window.location.href = "<?echo $dateFilterUrl?>" + (new Date(item.datapoint[0])).format('yyyy-mm-dd');
        }
    });
    $j("#joyplot").bind("plothover", function (event, pos, item)
    {
        if (item)
        {
            $j("#joytip").css({'top':item.pageY+5, 'left':item.pageX+5});
            $j("#joytip").text((new Date(item.datapoint[0])).toLocaleFormat("%d %b")+"\n "+ getMoodName(item.datapoint[1]));
            $j("#joytip").show('fast');
            $j("#joytip").oneTime(1500,function()
            {
                this.hide('fast');
            });
        }
//        else
//            $j("#joytip").hide('fast');
    });
});
function getMoodName(mood)
{
    if(mood >= 0.5)
        return 'отличное';
    else if(mood >= 0.2 && mood < 0.5)
        return 'хорошее';
    else if(mood >= -0.2 && mood < 0.2)
        return 'нормальное';
    else if(mood >= -0.5 && mood < -0.2)
        return 'так себе';
    else if(mood < -0.5)
        return 'плохое';
}
</script>
