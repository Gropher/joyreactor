<?

/**
 * Blog form base class.
 *
 * @package    form
 * @subpackage blog
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseBlogForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'name'       => new sfWidgetFormInput(),
      'tag'        => new sfWidgetFormInput(),
      'rating'     => new sfWidgetFormInput(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'posts_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Post')),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'Blog', 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser')),
      'name'       => new sfValidatorString(array('max_length' => 255)),
      'tag'        => new sfValidatorString(array('max_length' => 20)),
      'rating'     => new sfValidatorInteger(),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
      'posts_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Post', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('blog[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Blog';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['posts_list']))
    {
      $this->setDefault('posts_list', $this->object->Posts->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->savePostsList($con);
  }

  public function savePostsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['posts_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $this->object->unlink('Posts', array());

    $values = $this->getValue('posts_list');
    if (is_array($values))
    {
      $this->object->link('Posts', $values);
    }
  }

}