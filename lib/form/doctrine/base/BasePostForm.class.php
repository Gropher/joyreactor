<?php

/**
 * Post form base class.
 *
 * @method Post getObject() Returns the current form's model object
 *
 * @package    Empaty
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'text'           => new sfWidgetFormTextarea(),
      'text_original'  => new sfWidgetFormTextarea(),
      'header'         => new sfWidgetFormTextarea(),
      'rating'         => new sfWidgetFormInputText(),
      'comments_count' => new sfWidgetFormInputText(),
      'mood'           => new sfWidgetFormInputText(),
      'type'           => new sfWidgetFormInputText(),
      'isNew'          => new sfWidgetFormInputCheckbox(),
      'lj'             => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'blogs_list'     => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Blog')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'text'           => new sfValidatorString(array('max_length' => 2147483647)),
      'text_original'  => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'header'         => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'rating'         => new sfValidatorNumber(array('required' => false)),
      'comments_count' => new sfValidatorInteger(array('required' => false)),
      'mood'           => new sfValidatorNumber(array('required' => false)),
      'type'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isNew'          => new sfValidatorBoolean(array('required' => false)),
      'lj'             => new sfValidatorBoolean(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'blogs_list'     => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Blog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['blogs_list']))
    {
      $this->setDefault('blogs_list', $this->object->Blogs->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveBlogsList($con);

    parent::doSave($con);
  }

  public function saveBlogsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['blogs_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Blogs->getPrimaryKeys();
    $values = $this->getValue('blogs_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Blogs', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Blogs', array_values($link));
    }
  }

}
