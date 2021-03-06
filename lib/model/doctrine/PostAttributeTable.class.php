<?
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PostAttributeTable extends Doctrine_Table
{
  /**
   * Ищет картинку, прикреплённую к посту
   *
   * @param string $image картинка в /uploads
   * @return PostAttribute атрибут, или null
   */
  public function FindImage($image)
  {
    $query = $this->createQuery()
          ->where('value = ?', '/uploads/' . $image)
          ->andWhere('type = ?', 'picture');

    return $query->fetchOne();
  }
}