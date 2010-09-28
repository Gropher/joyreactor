<?php

/**
 * user actions.
 *
 * @package    Empaty
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class peopleActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
  }

  public function executeTop(sfWebRequest $request)
  {

  }

  public function executeFriends(sfWebRequest $request)
  {
      $this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
      $this->forward404Unless($this->user);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->curUser = $this->getUser()->getGuardUser();
  	$this->user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forwardIf(!$this->user && !$this->curUser, 'sfGuardAuth', 'signin');
    if(!$this->user)
  		$this->redirect('people/show?username='.$this->curUser->getUsername());
    elseif($this->curUser == $this->user)
  		$this->setTemplate('my');
  	else
  		$this->setTemplate('show');
  }
}
