<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Post filter form base class.
 *
 * @package    filters
 * @subpackage Post *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BasePostFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'text'           => new sfWidgetFormFilterInput(),
      'rating'         => new sfWidgetFormFilterInput(),
      'comments_count' => new sfWidgetFormFilterInput(),
      'mood'           => new sfWidgetFormFilterInput(),
      'type'           => new sfWidgetFormFilterInput(),
      'isNew'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lj'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'blogs_list'     => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Blog')),
    ));

    $this->setValidators(array(
      'user_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'text'           => new sfValidatorPass(array('required' => false)),
      'rating'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'comments_count' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'mood'           => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'type'           => new sfValidatorPass(array('required' => false)),
      'isNew'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lj'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'blogs_list'     => new sfValidatorDoctrineChoiceMany(array('model' => 'Blog', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('post_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addBlogsListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query->leftJoin('r.BlogPost BlogPost')
          ->andWhereIn('BlogPost.blog_id', $values);
  }

  public function getModelName()
  {
    return 'Post';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'user_id'        => 'ForeignKey',
      'text'           => 'Text',
      'rating'         => 'Number',
      'comments_count' => 'Number',
      'mood'           => 'Number',
      'type'           => 'Text',
      'isNew'          => 'Boolean',
      'lj'             => 'Boolean',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
      'blogs_list'     => 'ManyKey',
    );
  }
}