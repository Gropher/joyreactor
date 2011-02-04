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
}
