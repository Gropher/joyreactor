<?

/**
 * Doctrine_File_Index form base class.
 *
 * @package    form
 * @subpackage doctrine_file_index
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseDoctrine_File_IndexForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'keyword'  => new sfWidgetFormInputHidden(),
      'field'    => new sfWidgetFormInputHidden(),
      'position' => new sfWidgetFormInputHidden(),
      'file_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'keyword'  => new sfValidatorDoctrineChoice(array('model' => 'Doctrine_File_Index', 'column' => 'keyword', 'required' => false)),
      'field'    => new sfValidatorDoctrineChoice(array('model' => 'Doctrine_File_Index', 'column' => 'field', 'required' => false)),
      'position' => new sfValidatorDoctrineChoice(array('model' => 'Doctrine_File_Index', 'column' => 'position', 'required' => false)),
      'file_id'  => new sfValidatorDoctrineChoice(array('model' => 'Doctrine_File_Index', 'column' => 'file_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doctrine_file_index[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Doctrine_File_Index';
  }

}