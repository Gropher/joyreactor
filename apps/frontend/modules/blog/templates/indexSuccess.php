<h2><? echo __('Список тэгов') ?></h2>
<? foreach ($blog_list as $blog): ?>
  <div>
  	<a href="<? echo url_for('@tag?name='.$blog->getTag()) ?>"><? echo $blog->getName() ?></a>
  </div>
<? endforeach; ?>

<? include_partial('global/paging', array('pageLen' =>sfConfig::get('app_blogs_per_page'),
                                            'itemsCount' => $count,
                                            'pageNo' => $page,
                                            'updateUrl' =>url_for('@list-tags').'/')) ?>

