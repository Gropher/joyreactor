<?

/**
 * Blog form.
 *
 * @package    form
 * @subpackage Blog
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class BlogForm extends BaseBlogForm
{
  public function configure()
  {
  	unset($this['created_at'], $this['updated_at'], $this['rating'], $this['posts_list'], $this['count']);
  	$this->setWidget('user_id', new sfWidgetFormInputHidden());
	$this->widgetSchema->setLabels(array(
      'name' => 'Название:'));
  	$this->setValidator('name',
      new sfValidatorString(array('required' => true,
        'trim' => true,
        'min_length' => 2,
        'max_length' => 255), 
      array('required' => 'Необходимо ввести название!',
      		'min_length' => 'минимальная длина названия - 2 символов',
      		'max_length' => 'максимальная длина названия - 255 символов')));
  }
}