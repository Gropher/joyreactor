<?php

/**
 * BasePostAttribute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $post_id
 * @property enum $type
 * @property string $value
 * @property string $origin
 * @property string $comment
 * @property Post $Post
 * 
 * @method integer       getId()      Returns the current record's "id" value
 * @method integer       getPostId()  Returns the current record's "post_id" value
 * @method enum          getType()    Returns the current record's "type" value
 * @method string        getValue()   Returns the current record's "value" value
 * @method string        getOrigin()  Returns the current record's "origin" value
 * @method string        getComment() Returns the current record's "comment" value
 * @method Post          getPost()    Returns the current record's "Post" value
 * @method PostAttribute setId()      Sets the current record's "id" value
 * @method PostAttribute setPostId()  Sets the current record's "post_id" value
 * @method PostAttribute setType()    Sets the current record's "type" value
 * @method PostAttribute setValue()   Sets the current record's "value" value
 * @method PostAttribute setOrigin()  Sets the current record's "origin" value
 * @method PostAttribute setComment() Sets the current record's "comment" value
 * @method PostAttribute setPost()    Sets the current record's "Post" value
 * 
 * @package    Empaty
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePostAttribute extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('post_attribute');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('post_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('type', 'enum', 10, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'tag',
              1 => 'picture',
              2 => 'audio',
              3 => 'video',
             ),
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('value', 'string', 2147483647, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2147483647,
             ));
        $this->hasColumn('origin', 'string', 1024, array(
             'type' => 'string',
             'notnull' => true,
             'default' => '',
             'length' => 1024,
             ));
        $this->hasColumn('comment', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));


        $this->index('value', array(
             'fields' => 
             array(
              0 => 'value(333)',
             ),
             ));
        $this->index('post_id', array(
             'fields' => 
             array(
              0 => 'post_id',
             ),
             ));
        $this->index('type', array(
             'fields' => 
             array(
              0 => 'type',
             ),
             ));
        $this->index('created_at', array(
             'fields' => 
             array(
              0 => 'created_at',
             ),
             ));
        $this->index('updated_at', array(
             'fields' => 
             array(
              0 => 'updated_at',
             ),
             ));
        $this->option('type', 'MYISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Post', array(
             'local' => 'post_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}