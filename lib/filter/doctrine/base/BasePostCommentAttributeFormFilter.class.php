<?php

/**
 * PostCommentAttribute filter form base class.
 *
 * @package    Empaty
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePostCommentAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'post_comment_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PostComment'), 'add_empty' => true)),
      'type'            => new sfWidgetFormChoice(array('choices' => array('' => '', 'tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'origin'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comment'         => new sfWidgetFormFilterInput(),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'post_comment_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('PostComment'), 'column' => 'id')),
      'type'            => new sfValidatorChoice(array('required' => false, 'choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'           => new sfValidatorPass(array('required' => false)),
      'origin'          => new sfValidatorPass(array('required' => false)),
      'comment'         => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('post_comment_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostCommentAttribute';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'post_comment_id' => 'ForeignKey',
      'type'            => 'Enum',
      'value'           => 'Text',
      'origin'          => 'Text',
      'comment'         => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
