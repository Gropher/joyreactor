<?if($user->getProfile()->getAvatar()):?>
    <?echo image_tag($user->getProfile()->getAvatar())?>
<?else:?>
    <?echo image_tag('/images/default_avatar.jpeg')?>
<?endif?>
