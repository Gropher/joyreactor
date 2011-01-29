<?php

/**
 * main actions.
 *
 * @package    Empaty
 * @subpackage main
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mainActions extends sfActions {

/**
 * Executes redirect action
 *
 * @param sfRequest $request A request object
 */
  public function executeRedirect(sfWebRequest $request) {
    $url = $request->getParameter('url');
    $this->redirect($url, 302);
  }

/**
 * Executes redirect image action
 *
 * @param sfRequest $request A request object
 */
  public function executeRedirectImage(sfWebRequest $request) {
    $image = $request->getParameter('url');
    $postAttribute = Doctrine::getTable('PostAttribute')->FindImage($image);
    if($postAttribute)
    {
      $this->redirect('@post?id=' . $postAttribute->getPostId());
    }

    $postCommentAttribute = Doctrine::getTable('PostCommentAttribute')->FindImage($image);
    if($postCommentAttribute)
    {
      $this->redirect('@post?id=' . $postCommentAttribute->getPostComment()->getPostId());
    }

    $this->image = $image;
  }


}
