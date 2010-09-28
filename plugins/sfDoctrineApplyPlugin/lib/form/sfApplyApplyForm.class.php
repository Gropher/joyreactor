<?php

class sfApplyApplyForm extends sfGuardUserProfileForm
{
  public function configure()
  {
    parent::configure();

    // We're making a new user or editing the user who is
    // logged in. In neither case is it appropriate for
    // the user to get to pick an existing userid. The user
    // also doesn't get to modify the validate field which
    // is part of how their account is verified by email.

    unset($this['user_id'], $this['validate'], $this['icq'], $this['jabber'], $this['commentsToJabber'], $this['commentsToIcq'], $this['commentsToMail'], $this['collectJabberStatus'], $this['collectIcqStatus'], $this['useCrossposting'], $this['ljlogin'], $this['ljpassword'], $this['fullname'], $this['avatar'], $this['about'], $this['notifyFriendline']);

    // Add username and password fields which we'll manage
    // on our own. Before you ask, I experimented with separately 
    // emitting, merging or embedding a form subclassed from 
    // sfGuardUser. It was vastly more work in every instance.
    // You have to clobber all of the other fields (you can 
    // automate that, but still). If you use embedForm you realize 
    // you've got a nested form that looks like a
    // nested form and an end user looking at that and
    // saying "why?" If you use mergeForm you can't save(). And if
    // you output the forms consecutively you have to manage your
    // own transactions. Adding two fields to the profile form
    // is definitely simpler.

    $this->setWidget('username',
      new sfWidgetFormInput(
        array(), array('maxlength' => 16)));
    $this->widgetSchema->moveField(
      'username', sfWidgetFormSchema::FIRST);
    $this->setWidget('password',
      new sfWidgetFormInputPassword(
        array(), array('maxlength' => 128)));
    $this->widgetSchema->moveField(
      'password', sfWidgetFormSchema::AFTER, 'username');
    $this->setWidget('password2',
      new sfWidgetFormInputPassword(
        array(), array('maxlength' => 128)));
    $this->widgetSchema->moveField(
      'password2', sfWidgetFormSchema::AFTER, 'password');
    $this->widgetSchema->setLabels(array(
      'password' => 'Пароль:',
      'username' => 'Логин:',
      'password2' => 'Пароль еще раз:'));

    $email = $this->getWidget('email');
//    $this->setWidget('email2',
//       new sfWidgetFormInput(
//        array(), array('maxlength' => $email->getAttribute('maxlength'))));
//    $this->widgetSchema->moveField(
//      'email2', sfWidgetFormSchema::AFTER, 'email');
//    $this->widgetSchema->setLabels(array(
//      'fullname' => 'Имя и фамилия',
//      'email2' => 'Подтверждение E-Mail'
//	));
    $this->widgetSchema->setNameFormat('sfApplyApply[%s]');
    $this->widgetSchema->setFormFormatterName('list');
    // We have the right to an opinion on these fields because we
    // implement at least part of their behavior. Validators for the
    // rest of the user profile come from the schema and from the
    // developer's form subclass
    $this->setValidator('username',
      new sfValidatorAnd(
        array(
          new sfValidatorString(array('required' => true,
            'trim' => true,
            'min_length' => 4,
            'max_length' => 16)),
          new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser',
            'column' => 'username'), array("invalid" => "Пользователь с таким логином уже существует. Выберите другой.")))
          ,array(),array('required' => 'Необходимо ввести логин!') ));
    $this->setValidator('password',
      new sfValidatorString(array('required' => true,
        'trim' => true,
        'min_length' => 6,
        'max_length' => 128), array('required' => 'Необходимо ввести пароль!')));
    $this->setValidator('password2', 
      new sfValidatorString(array('required' => true,
        'trim' => true,
        'min_length' => 6,
        'max_length' => 128), array('required' => 'Необходимо подтвердить пароль!')));
    $this->setValidator('email', 
      new sfValidatorAnd(
        array(
          new sfValidatorEmail(array('required' => true,
            'trim' => true)),
          new sfValidatorString(array('required' => true,
            'max_length' => 80)),
          new sfValidatorDoctrineUnique(array('model' => 'sfGuardUserProfile',
            'column' => 'email'), array("invalid" => "Пользователь с таким адресом e-mail уже существует. Если Вы забыли пароль, нажмите \"Отмена\", затем \"Восстановить пароль.\"")))
          ,array(),array('required' => 'Необходимо ввести e-mail!')));
//    $this->setValidator('email2', 
//      new sfValidatorEmail(array('required' => true,
//        'trim' => true)));
//    $this->setValidator('fullname',
//      new sfValidatorString(array('required' => false,
//        'trim' => true,
//        'min_length' => 6,
//        'max_length' => 128)));
    $schema = $this->validatorSchema;
    // Hey Fabien, adding more postvalidators is kinda verbose!
    $postValidator = $schema->getPostValidator();
    $postValidators = array(
      new sfValidatorSchemaCompare(
        'password', sfValidatorSchemaCompare::EQUAL, 'password2',
        array(), array('invalid' => 'Пароли не совпадают.')),
      /*new sfValidatorSchemaCompare(
        'email', sfValidatorSchemaCompare::EQUAL, 'email2',
        array(), array('invalid' => 'Адреса e-mail не совпадают.'))*/);
    if ($postValidator)
    {
      $postValidators[] = $postValidator;
    }
    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd($postValidators));
  }
  private $validate = null;
  public function setValidate($validate)
  {
    $this->validate = $validate;
  }
  public function doSave($con = null)
  {
    $user = new sfGuardUser();
    $user->setUsername($this->getValue('username'));
    $user->setPassword($this->getValue('password'));
    // They must confirm their account first
    $user->setIsActive(false);
    $user->save();
    $this->userId = $user->getId();
    return parent::doSave($con);
  }
  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);
    $object->setUserId($this->userId);
    $object->setValidate($this->validate);
    // Don't break subclasses!
    return $object;
  }
}

