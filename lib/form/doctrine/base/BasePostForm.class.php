<?

/**
 * Post form base class.
 *
 * @package    form
 * @subpackage post
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormDoctrineSelect(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'text'           => new sfWidgetFormTextarea(),
      'rating'         => new sfWidgetFormInput(),
      'comments_count' => new sfWidgetFormInput(),
      'mood'           => new sfWidgetFormInput(),
      'type'           => new sfWidgetFormInput(),
      'isNew'          => new sfWidgetFormInputCheckbox(),
      'lj'             => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'blogs_list'     => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Blog')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => 'Post', 'column' => 'id', 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser')),
      'text'           => new sfValidatorString(array('max_length' => 2147483647)),
      'rating'         => new sfValidatorNumber(),
      'comments_count' => new sfValidatorInteger(),
      'mood'           => new sfValidatorNumber(array('required' => false)),
      'type'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'isNew'          => new sfValidatorBoolean(array('required' => false)),
      'lj'             => new sfValidatorBoolean(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'blogs_list'     => new sfValidatorDoctrineChoiceMany(array('model' => 'Blog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

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
    parent::doSave($con);

    $this->saveBlogsList($con);
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

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $this->object->unlink('Blogs', array());

    $values = $this->getValue('blogs_list');
    if (is_array($values))
    {
      $this->object->link('Blogs', $values);
    }
  }

}