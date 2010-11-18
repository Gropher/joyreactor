<?php

require_once dirname(__FILE__).'/../lib/BlogGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/BlogGeneratorHelper.class.php';

/**
 * Blog actions.
 *
 * @package    Empaty
 * @subpackage Blog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BlogActions extends autoBlogActions
{
  /**
   * Сливает даный блог с другим, удаляя текущий
   */
  public function executeListMerge(sfWebRequest $request)
  {
    $this->blog = $this->getRoute()->getObject();
    $this->newBlog = Doctrine::getTable('Blog')->find($request->getParameter('newBlog'));

    if(!$this->newBlog)
    {
      $this->blogs = Doctrine::getTable('Blog')->findAll();
      return;
    }

    if($this->newBlog->getId() == $this->blog->getId())
    {
      $this->getUser()->setFlash('notice', 'Нельзя слить с самим собой');
      $this->blogs = Doctrine::getTable('Blog')->findAll();
      return;
    }

    $this->blog->MergeBlogs($this->newBlog);
    $this->getUser()->setFlash('notice', 'Блоги успешно слиты');
    $this->redirect('@blog');
  }
}
