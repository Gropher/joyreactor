<?

/**
 * Post filter form.
 *
 * @package    filters
 * @subpackage Post *
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 11675 2008-09-19 15:21:38Z fabien $
 */
class PostFormFilter extends BasePostFormFilter
{
  public function configure()
  {
    unset($this['blogs_list'], $this['user_id']);
  }
}