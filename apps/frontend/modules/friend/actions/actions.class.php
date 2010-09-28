<?

/**
 * friend actions.
 *
 * @package    jobeet
 * @subpackage friend
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class friendActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $this->user = Doctrine::getTable('sfGuardUser')->find(array($request->getParameter('user_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    $this->forward404Unless($this->user);
    if(!$this->curUser->hasFriend($this->user))
    {
        $this->friend = new Friend();
        $this->friend->User = $this->curUser;
        $this->friend->Friend = $this->user;
        $this->friend->save();
    }
    return $this->renderPartial('friend/link', array('user' => $this->user));
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->user = Doctrine::getTable('sfGuardUser')->find(array($request->getParameter('user_id')));
    $this->curUser = $this->getUser()->getGuardUser();
    $this->friend = $this->curUser->getFriend($this->user);
    $this->forward404Unless($this->user);
    if($this->friend)
        $this->friend->delete();
    return $this->renderPartial('friend/link', array('user' => $this->user));
  }
}