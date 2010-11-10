<?php

/**
 * sfApply actions.
 *
 * @package    5seven5
 * @subpackage sfApply
 * @author     Tom Boutell, tom@punkave.com
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class BasesfApplyActions extends sfActions
{
  public function executeApply(sfRequest $request)
  {
    $this->form = $this->newForm('sfApplyApplyForm');
    $this->partnerId = $request->getParameter('partnerId', false);
    if(!$this->partnerId)
        $this->partnerId = isset($_COOKIE['partnerId'])? $_COOKIE['partnerId'] : 1;
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplyApply'));
      if ($this->form->isValid())
      {
        $guid = "n" . self::createGuid();
        $this->form->setValidate($guid);
        $this->form->save();
        $this->getUser()->signin($this->form->getObject()->getUser(), true);
        try
        {
          // Create the mailer and message objects
          $mailer = $this->getMailer();
         
          // Render message parts
          $profile = $this->form->getObject();
          $mailContext = array('name' => $profile->getFullname(),
            'validate' => $profile->getValidate(), 'partnerId' => $this->partnerId);

          $message = Swift_Message::newInstance();
          $from = sfConfig::get('app_sfApplyPlugin_from');
          $message->setFrom($from['email'], $from['fullname']);
          $message->setTo($profile->getEmail(), $profile->getUser()->getUsername());
          $message->setSubject(sfConfig::get('app_sfApplyPlugin_apply_subject', "Активация аккаунта на сайте " . $request->getHost()));
          $message->setBody($this->getPartial('sfApply/sendValidateNew', $mailContext), 'text/html');
          $message->addPart($this->getPartial('sfApply/sendValidateNewText', $mailContext), 'text/plain');
          $mailer->send($message);
          return 'After';
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
          $profile = $this->form->getObject();
          $user = $profile->getUser();
          $user->delete();
          // You could re-throw $e here if you want to 
          // make it available for debugging purposes
          return 'MailerError';
        }
      }
    }
  }

  public function executeReactivate(sfRequest $request)
  {
        $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
        if(!$user || $user->getIsActive()) return;
        try
        {
          // Create the mailer and message objects
          $mailer = $this->getMailer();

          // Render message parts
          $profile = $user->getProfile();
          $profile->setValidate('n' . self::createGuid());
          $profile->save();
          $mailContext = array('name' => $profile->getFullname(),
            'validate' => $profile->getValidate());

          $message = Swift_Message::newInstance();
          $from = sfConfig::get('app_sfApplyPlugin_from');
          $message->setFrom($from['email'], $from['fullname']);
          $message->setTo($profile->getEmail(), $profile->getUser()->getUsername());
          $message->setSubject(sfConfig::get('app_sfApplyPlugin_apply_subject', "Активация аккаунта на сайте " . $request->getHost()));
          $message->setBody($this->getPartial('sfApply/sendValidateNew', $mailContext), 'text/html');
          $message->addPart($this->getPartial('sfApply/sendValidateNewText', $mailContext), 'text/plain');
          $mailer->send($message);
          return 'After';
        }
        catch (Exception $e)
        {
          $mailer->disconnect();
          $profile = $this->form->getObject();
          $user = $profile->getUser();
          $user->delete();
          // You could re-throw $e here if you want to
          // make it available for debugging purposes
          return 'MailerError';
        }
  }
  
  public function executeResetRequest(sfRequest $request)
  {
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      $guardUser = $this->getUser()->getGuardUser();
      $this->forward404Unless($guardUser);
      return $this->resetRequestBody($guardUser);
    }
    else
    {
      $this->form = $this->newForm('sfApplyResetRequestForm');
      if ($request->isMethod('post'))
      {
        $this->form->bind($request->getParameter('sfApplyResetRequest'));
        if ($this->form->isValid())
        {
          $user = sfGuardUserTable::retrieveByUsername(
            $this->form->getValue('username'));
          return $this->resetRequestBody($user);
        }
      }
    }
  }

  public function resetRequestBody($user)
  {
    $this->forward404Unless($user);

    $profile = $user->getProfile();
    $profile->setValidate('r' . self::createGuid());
    $profile->save();
    // Create the mailer and message objects
    $mailer = $this->getMailer();

    // Render message parts
    $mailContext = array('name' => $profile->getFullname(),
      'validate' => $profile->getValidate());

    $message = Swift_Message::newInstance();
    $from = sfConfig::get('app_sfApplyPlugin_from');
    $message->setFrom($from['email'], $from['fullname']);
    $message->setTo($profile->getEmail(), $profile->getUser()->getUsername());
    $message->setSubject(sfConfig::get('app_sfApplyPlugin_reset_subject',"Изменение пароля на сайте " . $this->getRequest()->getHost()));
    $message->setBody($this->getPartial('sfApply/sendValidateReset', $mailContext), 'text/html');
    $message->addPart($this->getPartial('sfApply/sendValidateResetText', $mailContext), 'text/plain');
    $mailer->send($message);
    return 'After';
  }

  public function executeConfirm(sfRequest $request)
  {
    $validate = $this->request->getParameter('validate');
    // 0.6.3: oops, this was in sfGuardUserProfilePeer in my application
    // and therefore never got shipped with the plugin until I built
    // a second site and spotted it!

    // Note that this only works if you set foreignAlias and
    // foreignType correctly 
    $sfGuardUser = Doctrine_Query::create()->
      from("sfGuardUser u")->
      innerJoin("u.Profile p with p.validate = ?", $validate)->
      fetchOne();
    if (!$sfGuardUser)
    {
      return 'Invalid';
    }
    $type = self::getValidationType($validate);
    if (!strlen($validate))
    {
      return 'Invalid';
    }
    $profile = $sfGuardUser->getProfile();
    $profile->setValidate(null);
    $profile->save();
    if ($type == 'New')
    {
      if($this->request->getParameter('partnerId')) {
          $partner = Doctrine::getTable('sfGuardUser')->find(array($this->request->getParameter('partnerId')));
          if($partner) {
              $partner->getProfile()->setRating($partner->getProfile()->getRating() + sfConfig::get('app_user_partner_rating'));
              $partner->getProfile()->save();
          }
      }
      $sfGuardUser->setIsActive(true);  
      $sfGuardUser->save();
      $this->getUser()->signIn($sfGuardUser);
    }
    if ($type == 'Reset')
    {
      $this->getUser()->setAttribute('Reset', 
        $sfGuardUser->getId(), 'sfApplyPlugin');
      return $this->redirect('sfApply/reset');
    }
  }

  public function executeReset(sfRequest $request)
  {
    $this->form = $this->newForm('sfApplyResetForm');
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplyReset'));
      if ($this->form->isValid())
      {
        $this->id = $this->getUser()->getAttribute(
          'Reset', false, 'sfApplyPlugin', false);
        $this->forward404Unless($this->id);
        $this->sfGuardUser = Doctrine::getTable('sfGuardUser')->find($this->id);
        $this->forward404Unless($this->sfGuardUser);
        $sfGuardUser = $this->sfGuardUser;
        $sfGuardUser->setPassword($this->form->getValue('password'));
        $sfGuardUser->save();
        $this->getUser()->signIn($sfGuardUser);
        $this->getUser()->setAttribute(
          'Reset', null, 'sfApplyPlugin');
        return 'After';
      }
    }
  }

  public function executeResetCancel()
  {
    $this->getUser()->setAttribute(
      'Reset', null, 'sfApplyPlugin');
    return $this->redirect('@homepage'); 
  }

  public function executeSettings(sfRequest $request)
  {
    // sfApplySettingsForm inherits from sfApplyApplyForm, which
    // inherits from sfGuardUserProfile. That minimizes the amount
    // of duplication of effort. If you want, you can use a different
    // form class. I suggest inheriting from sfApplySettingsForm and
    // making further changes after calling parent::configure() from
    // your own configure() method. 

    $profile = $this->getUser()->getProfile();
    $this->form = $this->newForm('sfApplySettingsForm', $profile);
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('sfApplySettings'), $request->getFiles('sfApplySettings'));
      if ($this->form->isValid())
      {
        $this->form->save();
        return $this->redirect('people/show?username='.$this->getUser()->getUsername());
      }
    }
  }

  static private function createGuid()
  {
    $guid = "";
    // This was 16 before, which produced a string twice as
    // long as desired. I could change the schema instead
    // to accommodate a validation code twice as big, but
    // that is completely unnecessary and would break 
    // the code of anyone upgrading from the 1.0 version.
    // Ridiculously unpasteable validation URLs are a 
    // pet peeve of mine anyway.
    for ($i = 0; ($i < 8); $i++) {
      $guid .= sprintf("%02x", mt_rand(0, 255));
    }
    return $guid;
  }
  
  static private function getValidationType($validate)
  {
    $t = substr($validate, 0, 1);  
    if ($t == 'n')
    {
      return 'New';
    } 
    elseif ($t == 'r')
    {
      return 'Reset';
    }
    else
    {
      return sfView::NONE;
    }
  }

  // A convenience method to instantiate a form of the
  // specified class... unless the user has specified a
  // replacement class in app.yml. Sweet, no?
  protected function newForm($className, $object = null)
  {
    $key = "app_sfApplyPlugin_$className" . "_class";
    $class = sfConfig::get($key,
      $className);
    if ($object !== null)
    {
      return new $class($object);
    }
    return new $class;
  }
}
