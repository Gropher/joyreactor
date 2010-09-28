<?

/**
 * PostAttribute form base class.
 *
 * @package    form
 * @subpackage post_attribute
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePostAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'post_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'Post', 'add_empty' => false)),
      'type'       => new sfWidgetFormChoice(array('choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfWidgetFormTextarea(),
      'origin'     => new sfWidgetFormTextarea(),
      'comment'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'PostAttribute', 'column' => 'id', 'required' => false)),
      'post_id'    => new sfValidatorDoctrineChoice(array('model' => 'Post')),
      'type'       => new sfValidatorChoice(array('choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfValidatorString(array('max_length' => 2147483647)),
      'origin'     => new sfValidatorString(array('max_length' => 1024)),
      'comment'    => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('post_attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostAttribute';
  }

}