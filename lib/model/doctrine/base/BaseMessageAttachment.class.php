<?php

/**
 * BaseMessageAttachment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $message_id
 * @property enum $type
 * @property string $value
 * @property string $comment
 * @property Post $Message
 * 
 * @method integer           getId()         Returns the current record's "id" value
 * @method integer           getMessageId()  Returns the current record's "message_id" value
 * @method enum              getType()       Returns the current record's "type" value
 * @method string            getValue()      Returns the current record's "value" value
 * @method string            getComment()    Returns the current record's "comment" value
 * @method Post              getMessage()    Returns the current record's "Message" value
 * @method MessageAttachment setId()         Sets the current record's "id" value
 * @method MessageAttachment setMessageId()  Sets the current record's "message_id" value
 * @method MessageAttachment setType()       Sets the current record's "type" value
 * @method MessageAttachment setValue()      Sets the current record's "value" value
 * @method MessageAttachment setComment()    Sets the current record's "comment" value
 * @method MessageAttachment setMessage()    Sets the current record's "Message" value
 * 
 * @package    Empaty
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMessageAttachment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('message_attachment');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('message_id', 'integer', 4, array(
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
        $this->hasColumn('comment', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));


        $this->index('message_id', array(
             'fields' => 
             array(
              0 => 'post_id',
             ),
             'type' => NULL,
             ));
        $this->index('type', array(
             'fields' => 
             array(
              0 => 'type',
             ),
             'type' => NULL,
             ));
        $this->index('created_at', array(
             'fields' => 
             array(
              0 => 'created_at',
             ),
             'type' => NULL,
             ));
        $this->index('updated_at', array(
             'fields' => 
             array(
              0 => 'updated_at',
             ),
             'type' => NULL,
             ));
        $this->option('type', 'MYISAM');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Post as Message', array(
             'local' => 'message_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}