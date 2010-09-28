<?

/**
 * BlogPost form base class.
 *
 * @package    form
 * @subpackage blog_post
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseBlogPostForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'blog_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'Blog', 'add_empty' => false)),
      'post_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'Post', 'add_empty' => false)),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'BlogPost', 'column' => 'id', 'required' => false)),
      'blog_id'    => new sfValidatorDoctrineChoice(array('model' => 'Blog')),
      'post_id'    => new sfValidatorDoctrineChoice(array('model' => 'Post')),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('blog_post[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'BlogPost';
  }

}