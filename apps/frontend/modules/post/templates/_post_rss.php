<? echo __('Автор').': '.link_to($post->getUser()->getUsername(), 'user/'.$post->getUser()->getUsername(), 'absolute=true') ?>
<br/>
<? echo __('Настроение').': '.$post->getMoodNameI18N() ?>
<br/>
<? include_partial('post/post_content', array('post' => $post)) ?>
<br/>
<?echo link_to(__("Комментировать"), "post/show?noajax=1&id=".$post->getId(), 'absolute=true')?>&nbsp;
<?echo link_to(__("Голосовать за"), "post_vote/create?vote=plus&noajax=1&post_id=".$post->getId(), 'absolute=true')?>&nbsp;
<?echo link_to(__("Голосовать против"), "post_vote/create?vote=minus&noajax=1&post_id=".$post->getId(), 'absolute=true')?>