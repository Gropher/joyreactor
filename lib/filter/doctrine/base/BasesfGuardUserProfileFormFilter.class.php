<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * sfGuardUserProfile filter form base class.
 *
 * @package    filters
 * @subpackage sfGuardUserProfile *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasesfGuardUserProfileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'             => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'email'               => new sfWidgetFormFilterInput(),
      'fullname'            => new sfWidgetFormFilterInput(),
      'icq'                 => new sfWidgetFormFilterInput(),
      'jabber'              => new sfWidgetFormFilterInput(),
      'commentsToJabber'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'commentsToIcq'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'commentsToMail'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'collectJabberStatus' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'collectIcqStatus'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'useCrossposting'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'notifyFriendline'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'ljlogin'             => new sfWidgetFormFilterInput(),
      'ljpassword'          => new sfWidgetFormFilterInput(),
      'avatar'              => new sfWidgetFormFilterInput(),
      'about'               => new sfWidgetFormFilterInput(),
      'rating'              => new sfWidgetFormFilterInput(),
      'validate'            => new sfWidgetFormFilterInput(),
      'isNew'               => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'email'               => new sfValidatorPass(array('required' => false)),
      'fullname'            => new sfValidatorPass(array('required' => false)),
      'icq'                 => new sfValidatorPass(array('required' => false)),
      'jabber'              => new sfValidatorPass(array('required' => false)),
      'commentsToJabber'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'commentsToIcq'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'commentsToMail'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'collectJabberStatus' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'collectIcqStatus'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'useCrossposting'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'notifyFriendline'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'ljlogin'             => new sfValidatorPass(array('required' => false)),
      'ljpassword'          => new sfValidatorPass(array('required' => false)),
      'avatar'              => new sfValidatorPass(array('required' => false)),
      'about'               => new sfValidatorPass(array('required' => false)),
      'rating'              => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'validate'            => new sfValidatorPass(array('required' => false)),
      'isNew'               => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfile';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'user_id'             => 'ForeignKey',
      'email'               => 'Text',
      'fullname'            => 'Text',
      'icq'                 => 'Text',
      'jabber'              => 'Text',
      'commentsToJabber'    => 'Boolean',
      'commentsToIcq'       => 'Boolean',
      'commentsToMail'      => 'Boolean',
      'collectJabberStatus' => 'Boolean',
      'collectIcqStatus'    => 'Boolean',
      'useCrossposting'     => 'Boolean',
      'notifyFriendline'    => 'Boolean',
      'ljlogin'             => 'Text',
      'ljpassword'          => 'Text',
      'avatar'              => 'Text',
      'about'               => 'Text',
      'rating'              => 'Number',
      'validate'            => 'Text',
      'isNew'               => 'Boolean',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}