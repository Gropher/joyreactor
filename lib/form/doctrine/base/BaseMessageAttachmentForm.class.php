<?php

/**
 * MessageAttachment form base class.
 *
 * @method MessageAttachment getObject() Returns the current form's model object
 *
 * @package    Empaty
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMessageAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'message_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Message'), 'add_empty' => false)),
      'type'       => new sfWidgetFormChoice(array('choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfWidgetFormTextarea(),
      'comment'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'message_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Message'))),
      'type'       => new sfValidatorChoice(array('choices' => array(0 => 'tag', 1 => 'picture', 2 => 'audio', 3 => 'video'))),
      'value'      => new sfValidatorString(array('max_length' => 2147483647)),
      'comment'    => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('message_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MessageAttachment';
  }

}
