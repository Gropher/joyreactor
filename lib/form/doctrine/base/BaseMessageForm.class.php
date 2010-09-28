<?

/**
 * Message form base class.
 *
 * @package    form
 * @subpackage message
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseMessageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'object_id'  => new sfWidgetFormInput(),
      'direction'  => new sfWidgetFormInput(),
      'type'       => new sfWidgetFormInput(),
      'protocol'   => new sfWidgetFormInput(),
      'status'     => new sfWidgetFormInput(),
      'text'       => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'Message', 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser')),
      'object_id'  => new sfValidatorInteger(array('required' => false)),
      'direction'  => new sfValidatorString(array('max_length' => 255)),
      'type'       => new sfValidatorString(array('max_length' => 255)),
      'protocol'   => new sfValidatorString(array('max_length' => 255)),
      'status'     => new sfValidatorString(array('max_length' => 255)),
      'text'       => new sfValidatorString(array('max_length' => 2147483647)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Message';
  }

}