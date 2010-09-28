<?

require_once(sfConfig::get('sf_lib_dir').'/filter/doctrine/BaseFormFilterDoctrine.class.php');

/**
 * Blog filter form base class.
 *
 * @package    filters
 * @subpackage Blog *
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class BaseBlogFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'name'       => new sfWidgetFormFilterInput(),
      'tag'        => new sfWidgetFormFilterInput(),
      'rating'     => new sfWidgetFormFilterInput(),
      'created_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'posts_list' => new sfWidgetFormDoctrineChoiceMany(array('model' => 'Post')),
    ));

    $this->setValidators(array(
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'sfGuardUser', 'column' => 'id')),
      'name'       => new sfValidatorPass(array('required' => false)),
      'tag'        => new sfValidatorPass(array('required' => false)),
      'rating'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'posts_list' => new sfValidatorDoctrineChoiceMany(array('model' => 'Post', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('blog_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addPostsListColumnQuery(Doctrine_Query $query, $field, $values)
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
          ->andWhereIn('BlogPost.post_id', $values);
  }

  public function getModelName()
  {
    return 'Blog';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'user_id'    => 'ForeignKey',
      'name'       => 'Text',
      'tag'        => 'Text',
      'rating'     => 'Number',
      'created_at' => 'Date',
      'updated_at' => 'Date',
      'posts_list' => 'ManyKey',
    );
  }
}