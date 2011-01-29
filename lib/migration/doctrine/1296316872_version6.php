<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version6 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('post_comment_attribute', array(
             'id' => 
             array(
              'type' => 'integer',
              'primary' => '1',
              'autoincrement' => '1',
              'length' => '4',
             ),
             'post_comment_id' => 
             array(
              'type' => 'integer',
              'notnull' => '1',
              'length' => '4',
             ),
             'type' => 
             array(
              'type' => 'enum',
              'values' => 
              array(
              0 => 'tag',
              1 => 'picture',
              2 => 'audio',
              3 => 'video',
              ),
              'notnull' => '1',
              'length' => '10',
             ),
             'value' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'length' => '2147483647',
             ),
             'origin' => 
             array(
              'type' => 'string',
              'notnull' => '1',
              'default' => '',
              'length' => '1024',
             ),
             'comment' => 
             array(
              'type' => 'string',
              'length' => '2147483647',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'MYISAM',
             'indexes' => 
             array(
              'post_comment_id' => 
              array(
              'fields' => 
              array(
               0 => 'post_comment_id',
              ),
              ),
              'type' => 
              array(
              'fields' => 
              array(
               0 => 'type',
              ),
              ),
              'created_at' => 
              array(
              'fields' => 
              array(
               0 => 'created_at',
              ),
              ),
              'updated_at' => 
              array(
              'fields' => 
              array(
               0 => 'updated_at',
              ),
              ),
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_unicode_ci',
             'charset' => 'utf8',
             ));
        $this->addColumn('post', 'text_original', 'string', '2147483647', array(
             ));
        $this->addColumn('post_comment', 'comment_original', 'string', '2147483647', array(
             ));
    }

    public function down()
    {
        $this->dropTable('post_comment_attribute');
        $this->removeColumn('post', 'text_original');
        $this->removeColumn('post_comment', 'comment_original');
    }
}
