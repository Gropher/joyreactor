<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Doctrine_File filter form base class.
 *
 * @package    filters
 * @subpackage Doctrine_File *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseDoctrine_FileFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'url' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'url' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doctrine_file_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Doctrine_File';
  }

  public function getFields()
  {
    return array(
      'id'  => 'Number',
      'url' => 'Text',
    );
  }
}