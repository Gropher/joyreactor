<?

/**
 * sfGuardUserProfileIndex form base class.
 *
 * @package    form
 * @subpackage sf_guard_user_profile_index
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasesfGuardUserProfileIndexForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'keyword'  => new sfWidgetFormInputHidden(),
      'field'    => new sfWidgetFormInputHidden(),
      'position' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUserProfileIndex', 'column' => 'id', 'required' => false)),
      'keyword'  => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUserProfileIndex', 'column' => 'keyword', 'required' => false)),
      'field'    => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUserProfileIndex', 'column' => 'field', 'required' => false)),
      'position' => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUserProfileIndex', 'column' => 'position', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_index[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfileIndex';
  }

}