<?

/**
 * PostVote form base class.
 *
 * @package    form
 * @subpackage post_vote
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePostVoteForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'sfGuardUser', 'add_empty' => false)),
      'post_id'    => new sfWidgetFormDoctrineSelect(array('model' => 'Post', 'add_empty' => false)),
      'comment'    => new sfWidgetFormTextarea(),
      'power'      => new sfWidgetFormInput(),
      'isNew'      => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'PostVote', 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser')),
      'post_id'    => new sfValidatorDoctrineChoice(array('model' => 'Post')),
      'comment'    => new sfValidatorString(array('max_length' => 2147483647, 'required' => false)),
      'power'      => new sfValidatorInteger(),
      'isNew'      => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('post_vote[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostVote';
  }

}