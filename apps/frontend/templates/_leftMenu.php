<ul>
    <?php if (has_slot('leftmenu')): ?>
        <?php include_slot('leftmenu') ?>
    <? else: ?>
        <? if(!$sf_user->isAuthenticated()): ?>
            <li>
                <h2>Привет!</h2>
                <div class="sidebarContent">
		    Ты троль, лжец и девственник? <br/><br/> 
                    <span style="font-size: 21px;"><a href="/register/">Присоединяйся!</a></span><br/>
                </div>
            </li>
        <? endif ?>
	<!--
        <li>
            <h2><? echo __('Пульс настроения сайта') ?></h2>
            <div class="sidebarContent">
                <? //include_partial('global/joyPlot', array('joyplot' => Post::getJoyPlot())) ?>
                &nbsp;&nbsp;&nbsp;<small><small><span><?echo __('Настроение сайта сегодня').': <i>'.Post::getTodayMood().'</i>'?></span></small></small>
            </div>
        </li>
	-->
        <? include_partial('global/tagcloud') ?>
        <? include_partial('global/onlineUsers') ?>
        <? include_partial('global/friendConnect') ?>
    <? endif ?>
    <!--LiveInternet counter--><script type="text/javascript"><!--
    var tag = 'img';
    document.write("<a href='http://www.liveinternet.ru/click' "+
    "target=_blank><"+tag+" src='//counter.yadro.ru/hit?t26.6;r"+
    escape(document.referrer)+((typeof(screen)=="undefined")?"":
    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
    ";"+Math.random()+
    "' alt='' title='LiveInternet: показано число посетителей за"+
    " сегодня' "+
    "border='0' width='88' height='15'><\/a>")
    //--></script><!--/LiveInternet-->
</ul>
