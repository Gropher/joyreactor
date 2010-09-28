<?php

class sfApplyResetForm extends sfForm
{
  public function configure()
  {
    $this->setWidget('password',
      new sfWidgetFormInputPassword(
   		array(), array('maxlength' => 128)));
    $this->setWidget('password2',
      new sfWidgetFormInputPassword(
        array(), array('maxlength' => 128)));
    $this->widgetSchema->setNameFormat('sfApplyReset[%s]');
    $this->widgetSchema->setFormFormatterName('list');
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
    $this->widgetSchema->setLabels(array(
      'password' => 'Пароль',
      'password2' => 'Пароль еще раз'));
    $this->validatorSchema->setPostValidator(
      new sfValidatorSchemaCompare(
        'password', sfValidatorSchemaCompare::EQUAL, 'password2',
        array(), array('invalid' => 'Пароли не совпадают.')));
  }
}

