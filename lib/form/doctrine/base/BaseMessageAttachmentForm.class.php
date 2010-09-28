<?

/**
 * MessageAttachment form base class.
 *
 * @package    form
 * @subpackage message_attachment
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseMessageAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'message_id' => new sfWidgetFormDoctrineSelect(array('model' => 'Post', 'add_empty' => false)),
      'type'       => new sfWidgetFormChoice(array('choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfWidgetFormTextarea(),
      'comment'    => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'MessageAttachment', 'column' => 'id', 'required' => false)),
      'message_id' => new sfValidatorDoctrineChoice(array('model' => 'Post')),
      'type'       => new sfValidatorChoice(array('choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfValidatorString(array('max_length' => 2147483647)),
      'comment'    => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('message_attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'MessageAttachment';
  }

}