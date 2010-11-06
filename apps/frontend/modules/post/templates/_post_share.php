<? use_helper('Javascript', 'Text', 'Form', 'Parse', 'UserTime', 'DeltaCount'); ?>
<span>
    <a target='_blank' style='text-decoration:none;' href='http://vkontakte.ru/share.php?url=<?echo url_for('post/show?id='.$post->getId(), array('absolute' => true))?>'>
        <image src='http://vk.com/images/vk16.png' />&nbsp;ВКонтакте
    </a>
</span><br/>
<iframe allowtransparency="true" frameborder="0" scrolling="no"
        src="http://platform.twitter.com/widgets/tweet_button.html?url=<?echo urlencode(url_for('post/show?id='.$post->getId(), array('absolute' => true)))?>"
        style="width:230px; height:21px;">
</iframe><br/>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?echo url_for('post/show?id='.$post->getId(), array('absolute' => true))?>&amp;layout=standard&amp;show_faces=true&amp;width=110&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:310px; height:23px;" allowTransparency="true">
</iframe><br/>
<label for='share-blog'><?echo __('Код для блога:')?></label>&nbsp;&nbsp;&nbsp;&nbsp;
<input size=50 value='<?echo $post->getBlogCode()?>' name='share-blog' readonly='true' /><br/>
<label for='share-forum'><?echo __('Код для форума:')?></label>
<input size=50 value='<?echo $post->getForumCode()?>' name='share-forum' readonly='true' />
