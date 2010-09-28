<? use_helper('Javascript'); ?>

<? if($sf_user->isAuthenticated()):  ?>
	<span id="friend_link">
		<? if($sf_user->getGuardUser()->hasFriend($user)): ?>
			<? echo link_to_remote(__('Удалить из друзей'), array(
				'update' => 'friend_link',
				'url' => 'friend/delete?user_id='.$user->getId())) ?>
		<? else: ?>
			<? echo link_to_remote(__('Добавить в друзья'), array(
				'update' => 'friend_link',
				'url' => 'friend/create?user_id='.$user->getId())) ?>
		<? endif; ?>
	</span>
<? endif;  ?>