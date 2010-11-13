<?php

/**
 * sfGuardUserProfile form base class.
 *
 * @method sfGuardUserProfile getObject() Returns the current form's model object
 *
 * @package    Empaty
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'email'               => new sfWidgetFormInputText(),
      'fullname'            => new sfWidgetFormInputText(),
      'icq'                 => new sfWidgetFormInputText(),
      'jabber'              => new sfWidgetFormInputText(),
      'commentsToJabber'    => new sfWidgetFormInputCheckbox(),
      'commentsToIcq'       => new sfWidgetFormInputCheckbox(),
      'commentsToMail'      => new sfWidgetFormInputCheckbox(),
      'collectJabberStatus' => new sfWidgetFormInputCheckbox(),
      'collectIcqStatus'    => new sfWidgetFormInputCheckbox(),
      'useCrossposting'     => new sfWidgetFormInputCheckbox(),
      'notifyFriendline'    => new sfWidgetFormInputCheckbox(),
      'ljlogin'             => new sfWidgetFormInputText(),
      'ljpassword'          => new sfWidgetFormInputText(),
      'avatar'              => new sfWidgetFormInputText(),
      'about'               => new sfWidgetFormTextarea(),
      'rating'              => new sfWidgetFormInputText(),
      'validate'            => new sfWidgetFormInputText(),
      'isNew'               => new sfWidgetFormInputCheckbox(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'email'               => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'fullname'            => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'icq'                 => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'jabber'              => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'commentsToJabber'    => new sfValidatorBoolean(array('required' => false)),
      'commentsToIcq'       => new sfValidatorBoolean(array('required' => false)),
      'commentsToMail'      => new sfValidatorBoolean(array('required' => false)),
      'collectJabberStatus' => new sfValidatorBoolean(array('required' => false)),
      'collectIcqStatus'    => new sfValidatorBoolean(array('required' => false)),
      'useCrossposting'     => new sfValidatorBoolean(array('required' => false)),
      'notifyFriendline'    => new sfValidatorBoolean(array('required' => false)),
      'ljlogin'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'ljpassword'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'avatar'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'about'               => new sfValidatorString(array('max_length' => 65536, 'required' => false)),
      'rating'              => new sfValidatorNumber(array('required' => false)),
      'validate'            => new sfValidatorString(array('max_length' => 17, 'required' => false)),
      'isNew'               => new sfValidatorBoolean(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

}
