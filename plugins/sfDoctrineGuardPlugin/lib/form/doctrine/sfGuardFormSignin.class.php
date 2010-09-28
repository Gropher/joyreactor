<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package form
 * @package sf_guard_user
 */
class sfGuardFormSignin extends BasesfGuardFormSignin
{
	public function configure()
	{
	    parent::configure();
        $this->widgetSchema->setDefault('remember', 'checked');
		$this->widgetSchema->setLabels(array(
	      'password' => 'Пароль:',
	      'username' => 'Логин:',
	      'remember' => 'Запомнить меня'));
		$this->setValidators(array(
	      'username' => new sfValidatorString(array(),array('required' => 'Необходимо ввести логин!')),
	      'password' => new sfValidatorString(array(),array('required' => 'Необходимо ввести пароль!')),
	      'remember' => new sfValidatorBoolean(),
	    ));
            $this->widgetSchema->setFormFormatterName('list');
	    $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());
	}
}