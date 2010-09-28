<? if($sf_user->isAuthenticated()):  ?>
	<? include_partial('favorite/link_content', array('post' => $post)) ?>
<? endif;  ?>