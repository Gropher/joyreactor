<?if(!isset($show_comments)) $show_comments=0 ?>
<? if(count($posts)): ?>
    <? foreach ($posts as $post): ?>
        <div id="postContainer<? echo $post->getId() ?>" >
            <? include_partial('post/post', array(
                'post' => $post,
                'show_comments' => $show_comments,
                'tagStyle' => isset($tagStyle) ? $tagStyle : 'h1'
                  ));?>
        </div>
    <? endforeach ?>
<? else: ?>
	<i><? echo __('нет записей') ?></i>
<? endif ?>