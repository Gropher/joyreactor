<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
<html>
    <head>
        <? include_http_metas() ?>
        <? include_metas() ?>
        <? include_title() ?>
        <? include_stylesheets() ?>
        <? include_javascripts() ?>
        <!--[if lte IE 7]>
                <script type="text/javascript" src="/js/unitpngfix.js"></script>
		<link rel="stylesheet" href="/css/lte7.css" type="text/css" media="screen" />
	<![endif]-->
	<meta name="google-site-verification" content="wgjnptO3Yx_w-OEQIB4a5nHsb-WnmhIx-TEXL2kXff4" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php if (has_slot('rsslink')): ?>
            <?php include_slot('rsslink') ?>
        <? else: ?>
        <link title="" type="application/rss+xml" rel="alternate" href="http://feeds2.feedburner.com/joyreactor"/>
        <?endif?>
    </head>
    <body>
        <div id="joytip"></div>
        <div id="container">
            <div id="header">
                <div class="logo"><? echo link_to(__('JoyReactor'), '@homepage') ?></div>
                <div class="description">Твоё хорошее настроение</div>
            </div>
            <div id="page">
                <div id="navcontainer">
                    <? include_partial('global/menu') ?>
                </div>
                <div id="searchBar">
                    <div id="submenu">
                        <? include_slot('menu2') ?>
                    </div>
                    <? include_partial('global/search') ?>
                </div>
                <div id="pageinner">
                    <div id="sidebar">
                        <? include_partial('global/leftMenu') ?>
                    </div>
                    <div id="content">
                        <div id="contentinner">
                            <? echo $sf_content ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer">  </div>
        </div>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-5461980-2");
                pageTracker._trackPageview();
            } catch(err) {}
        </script>
    </body>
</html>
