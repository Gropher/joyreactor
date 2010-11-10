<?php

/**
 * Message form base class.
 *
 * @method Message getObject() Returns the current form's model object
 *
 * @package    Empaty
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMessageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'object_id'  => new sfWidgetFormInputText(),
      'direction'  => new sfWidgetFormInputText(),
      'type'       => new sfWidgetFormInputText(),
      'protocol'   => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormInputText(),
      'text'       => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'object_id'  => new sfValidatorInteger(array('required' => false)),
      'direction'  => new sfValidatorString(array('max_length' => 255)),
      'type'       => new sfValidatorString(array('max_length' => 255)),
      'protocol'   => new sfValidatorString(array('max_length' => 255)),
      'status'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'text'       => new sfValidatorString(array('max_length' => 2147483647)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }

}
