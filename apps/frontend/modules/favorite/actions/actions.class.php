<?

/**
 * favorite actions.
 *
 * @package    Empaty
 * @subpackage favorite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class favoriteActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('post_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    if($this->post && $this->getUser()->isAuthenticated() && !$this->curUser->isFavorite($this->post))
    {
        $this->favorite = new Favorite();
        $this->favorite->User = $this->curUser;
        $this->favorite->Post = $this->post;
        $this->favorite->save();
    }
    return $this->renderPartial('favorite/link_content', array('post' => $this->post));
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('post_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    $this->favorite = $this->curUser->getFavorite($this->post);
    if($this->post && $this->getUser()->isAuthenticated() && $this->favorite)
        $this->favorite->delete();
    return $this->renderPartial('favorite/link_content', array('post' => $this->post));
  }

  public function executeCreateblog(sfWebRequest $request)
  {
    $this->blog = Doctrine::getTable('Blog')->find(array($request->getParameter('blog_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    $this->value = $request->getParameter('value');
    if($this->blog && $this->getUser()->isAuthenticated() && ($this->value == 1 || $this->value == -1) )
    {
        $this->favorite = $this->curUser->getFavoriteBlog($this->blog);
        if(!$this->favorite) {
            $this->favorite = new FavoriteBlog();
            $this->favorite->User = $this->curUser;
            $this->favorite->Blog = $this->blog;
        }
        $this->favorite->setValue($this->value);
        $this->favorite->save();
    }
    return $this->renderPartial('favorite/blog_link_content', array('blog' => $this->blog));
  }

  public function executeDeleteblog(sfWebRequest $request)
  {
    $this->blog = Doctrine::getTable('Blog')->find(array($request->getParameter('blog_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    $this->favorite = $this->curUser->getFavoriteBlog($this->blog);
    if($this->blog && $this->getUser()->isAuthenticated() && $this->favorite)
        $this->favorite->delete();
    return $this->renderPartial('favorite/blog_link_content', array('blog' => $this->blog));
  }
}