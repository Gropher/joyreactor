<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * sfGuardUserProfileIndex filter form base class.
 *
 * @package    filters
 * @subpackage sfGuardUserProfileIndex *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasesfGuardUserProfileIndexFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_profile_index_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserProfileIndex';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'keyword'  => 'Text',
      'field'    => 'Text',
      'position' => 'Number',
    );
  }
}