<?php

/**
 * sfGuardGroupPermission form base class.
 *
 * @method sfGuardGroupPermission getObject() Returns the current form's model object
 *
 * @package    Empaty
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasesfGuardGroupPermissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'group_id'      => new sfWidgetFormInputHidden(),
      'permission_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'group_id'      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('group_id')), 'empty_value' => $this->getObject()->get('group_id'), 'required' => false)),
      'permission_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('permission_id')), 'empty_value' => $this->getObject()->get('permission_id'), 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_group_permission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardGroupPermission';
  }

}
