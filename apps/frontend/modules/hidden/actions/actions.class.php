<?

/**
 * favorite actions.
 *
 * @package    Empaty
 * @subpackage favorite
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class hiddenActions extends sfActions {
    public function executeCreate(sfWebRequest $request) {
        $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('post_id')));
        $this->curUser = $this->getUser()->getGuardUser();
        $this->forward404Unless($this->post);
        if(!$this->curUser->isHidden($this->post)) {
            $this->hidden = $this->curUser->getHidden($this->post);
            if($this->hidden)
               $this->hidden->delete();
            $this->hidden = new Hidden();
            $this->hidden->User = $this->curUser;
            $this->hidden->Post = $this->post;
            $this->hidden->setValue(1);
            $this->hidden->save();
        }
        return $this->renderPartial('post/post', array('post' => $this->post, 'showAddComment' => $request->getParameter('showAddComment'), 'show_comments' => $request->getParameter('show_comments')));
    }

    public function executeDelete(sfWebRequest $request) {
        $this->post = Doctrine::getTable('Post')->find(array($request->getParameter('post_id')));
        $this->curUser = $this->getUser()->getGuardUser();
        $this->forward404Unless($this->post);
        if($this->curUser->isHidden($this->post)) {
            $this->hidden = $this->curUser->getHidden($this->post);
            if($this->hidden)
               $this->hidden->delete();
            $this->hidden = new Hidden();
            $this->hidden->User = $this->curUser;
            $this->hidden->Post = $this->post;
            $this->hidden->setValue(0);
            $this->hidden->save();
        }
        return $this->renderPartial('post/post', array('post' => $this->post, 'showAddComment' => $request->getParameter('showAddComment'), 'show_comments' => $request->getParameter('show_comments')));
    }
}