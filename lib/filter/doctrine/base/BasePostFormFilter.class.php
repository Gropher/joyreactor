<?php

/**
 * Post filter form base class.
 *
 * @package    Empaty
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePostFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'text'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'text_original'  => new sfWidgetFormFilterInput(),
      'header'         => new sfWidgetFormFilterInput(),
      'rating'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'comments_count' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mood'           => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormFilterInput(),
      'isNew'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lj'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'blogs_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Blog')),
    ));

    $this->setValidators(array(
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('User'), 'column' => 'id')),
      'text'           => new sfValidatorPass(array('required' => false)),
      'text_original'  => new sfValidatorPass(array('required' => false)),
      'header'         => new sfValidatorPass(array('required' => false)),
      'rating'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comments_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mood'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'type'           => new sfValidatorPass(array('required' => false)),
      'isNew'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lj'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'blogs_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Blog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addBlogsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.BlogPost BlogPost')
      ->andWhereIn('BlogPost.blog_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'user_id'        => 'ForeignKey',
      'text'           => 'Text',
      'text_original'  => 'Text',
      'header'         => 'Text',
      'rating'         => 'Number',
      'comments_count' => 'Number',
      'mood'           => 'Number',
      'type'           => 'Text',
      'isNew'          => 'Boolean',
      'lj'             => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'blogs_list'     => 'ManyKey',
    );
  }
}
