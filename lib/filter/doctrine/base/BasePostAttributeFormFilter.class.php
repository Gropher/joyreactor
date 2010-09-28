<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * PostAttribute filter form base class.
 *
 * @package    filters
 * @subpackage PostAttribute *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasePostAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'post_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'Post', 'add_empty' => true)),
      'type'       => new sfWidgetFormChoice(array('choices' => array('' => '', 'tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfWidgetFormFilterInput(),
      'origin'     => new sfWidgetFormFilterInput(),
      'comment'    => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'post_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Post', 'column' => 'id')),
      'type'       => new sfValidatorChoice(array('required' => false, 'choices' => array('tag' => 'tag', 'picture' => 'picture', 'audio' => 'audio', 'video' => 'video'))),
      'value'      => new sfValidatorPass(array('required' => false)),
      'origin'     => new sfValidatorPass(array('required' => false)),
      'comment'    => new sfValidatorPass(array('required' => false)),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('post_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PostAttribute';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'post_id'    => 'ForeignKey',
      'type'       => 'Enum',
      'value'      => 'Text',
      'origin'     => 'Text',
      'comment'    => 'Text',
      'created_at' => 'Date',
      'updated_at' => 'Date',
    );
  }
}