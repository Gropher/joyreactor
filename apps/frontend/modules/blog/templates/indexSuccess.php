<h2><? echo __('Коллективные блоги') ?></h2>
    <? foreach ($blog_list as $blog): ?>
    <div>
    	<a href="<? echo url_for('blog/show?id='.$blog->getId()) ?>"><? echo $blog->getName() ?></a>
    </div>
    <? endforeach; ?>
<hr/>
<? if($sf_user->isAuthenticated()):?>
	<a href="<? echo url_for('blog/new') ?>"><? echo __('Новый блог') ?></a>
<? endif; ?>