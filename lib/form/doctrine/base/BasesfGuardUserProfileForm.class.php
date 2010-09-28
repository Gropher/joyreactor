<?

/**
 * sfGuardUserProfile form base class.
 *
 * @package    form
 * @subpackage sf_guard_user_profile
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasesfGuardUserProfileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'user_id'             => new sfWidgetFormDoctrineSelect(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'email'               => new sfWidgetFormInput(),
      'fullname'            => new sfWidgetFormInput(),
      'icq'                 => new sfWidgetFormInput(),
      'jabber'              => new sfWidgetFormInput(),
      'commentsToJabber'    => new sfWidgetFormInputCheckbox(),
      'commentsToIcq'       => new sfWidgetFormInputCheckbox(),
      'commentsToMail'      => new sfWidgetFormInputCheckbox(),
      'collectJabberStatus' => new sfWidgetFormInputCheckbox(),
      'collectIcqStatus'    => new sfWidgetFormInputCheckbox(),
      'useCrossposting'     => new sfWidgetFormInputCheckbox(),
      'notifyFriendline'    => new sfWidgetFormInputCheckbox(),
      'ljlogin'             => new sfWidgetFormInput(),
      'ljpassword'          => new sfWidgetFormInput(),
      'avatar'              => new sfWidgetFormInput(),
      'about'               => new sfWidgetFormTextarea(),
      'rating'              => new sfWidgetFormInput(),
      'validate'            => new sfWidgetFormInput(),
      'isNew'               => new sfWidgetFormInputCheckbox(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUserProfile', 'column' => 'id', 'required' => false)),
      'user_id'             => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser')),
      'email'               => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'fullname'            => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'icq'                 => new sfValidatorString(array('max_length' => 15, 'required' => false)),
      'jabber'              => new sfValidatorString(array('max_length' => 80, 'required' => false)),
      'commentsToJabber'    => new sfValidatorBoolean(),
      'commentsToIcq'       => new sfValidatorBoolean(),
      'commentsToMail'      => new sfValidatorBoolean(),
      'collectJabberStatus' => new sfValidatorBoolean(),
      'collectIcqStatus'    => new sfValidatorBoolean(),
      'useCrossposting'     => new sfValidatorBoolean(),
      'notifyFriendline'    => new sfValidatorBoolean(),
      'ljlogin'             => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'ljpassword'          => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'avatar'              => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'about'               => new sfValidatorString(array('max_length' => 65536, 'required' => false)),
      'rating'              => new sfValidatorNumber(),
      'validate'            => new sfValidatorString(array('max_length' => 17, 'required' => false)),
      'isNew'               => new sfValidatorBoolean(array('required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

}