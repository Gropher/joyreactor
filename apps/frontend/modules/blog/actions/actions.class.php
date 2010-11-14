<?

/**
 * blog actions.
 *
 * @package    Empaty
 * @subpackage blog
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class blogActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
      $this->page = $request->getParameter('page');
      $this->count = Blog::getList('count');
      $this->blog_list = Blog::getList($this->page);
    }
    
    public function executeShow(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        if ($request->getParameter('id'))
            $this->blog = Doctrine::getTable('Blog')->find(array($request->getParameter('id')));
        else
            $this->blog = Blog::getByTag($request->getParameter('name'));
        $this->forward404Unless($this->blog);
        $this->title = $this->blog->getName()." / ";
        $this->getResponse()->setTitle($this->title . __("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
        $this->getResponse()->addMeta('description', strip_tags($this->blog->getDescription()));
    }
    
    public function executeNotag(sfWebRequest $request) {

    }

    public function executeUser(sfWebRequest $request) {
        sfApplicationConfiguration::getActive()->loadHelpers(array('I18N', 'Parse'));
        $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        $this->forward404Unless($this->user);
        if ($request->getParameter('id'))
            $this->blog = Doctrine::getTable('Blog')->find(array($request->getParameter('id')));
        else
            $this->blog = Blog::getByTag($request->getParameter('name'));
        $this->forward404Unless($this->blog);
        $this->getResponse()->setTitle($this->blog->getName()." / ".$this->user->getUsername()." / ".__("JoyReactor – твое хорошее настроние. Картинки, приколы, видео, демотиваторы."));
    }
    
    public function executeShowlist(sfWebRequest $request) {
        $page = $request->getParameter('page') ? $request->getParameter('page') : 1;
        $this->blog = Doctrine::getTable('Blog')->find(array($request->getParameter('id')));
        $this->forward404Unless($this->blog);
        return $this->renderPartial('post/postList', array('posts' => $this->blog->getLine($page)));
    }
}
