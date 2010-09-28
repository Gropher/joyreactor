<?php

class sfApplyResetRequestForm extends sfForm
{
  public function configure()
  {
    parent::configure();

    $this->setWidget('username',
      new sfWidgetFormInput(
        array(), array('maxlength' => 16)));
	$this->widgetSchema->setLabels(array(
      'username' => 'Логин:'));
    $this->setValidator('username',
      new sfValidatorAnd(
        array(
          new sfValidatorString(array('required' => true,
            'trim' => true,
            'min_length' => 4,
            'max_length' => 16)),
          new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser',
            'column' => 'username'), array("invalid" => "Пользователь с таким логином не существует."))),
          array(), array('required' => 'Необходимо ввести логин!')));
    $this->widgetSchema->setNameFormat('sfApplyResetRequest[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
}

