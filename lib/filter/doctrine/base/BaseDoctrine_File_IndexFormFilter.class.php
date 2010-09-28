<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Doctrine_File_Index filter form base class.
 *
 * @package    filters
 * @subpackage Doctrine_File_Index *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseDoctrine_File_IndexFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('doctrine_file_index_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Doctrine_File_Index';
  }

  public function getFields()
  {
    return array(
      'keyword'  => 'Text',
      'field'    => 'Text',
      'position' => 'Text',
      'file_id'  => 'Number',
    );
  }
}