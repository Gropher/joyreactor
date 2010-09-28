<p>
    <? echo __('Пользователь').' '.
                link_to($friend->getUser()->getUsername(),'post/user?username='.$friend->getUser()->getUsername(), 'absolute=true').
                ' '.__('добавил вас в друзья!') ?>
</p>