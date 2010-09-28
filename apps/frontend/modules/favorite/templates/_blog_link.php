<? if($sf_user->isAuthenticated()): ?>
	<? include_partial('favorite/blog_link_content', array('blog' => $blog)) ?>
<? endif ?>