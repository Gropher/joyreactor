<?

/**
 * Doctrine_File form base class.
 *
 * @package    form
 * @subpackage doctrine_file
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseDoctrine_FileForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'  => new sfWidgetFormInputHidden(),
      'url' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'  => new sfValidatorDoctrineChoice(array('model' => 'Doctrine_File', 'column' => 'id', 'required' => false)),
      'url' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('doctrine_file[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Doctrine_File';
  }

}