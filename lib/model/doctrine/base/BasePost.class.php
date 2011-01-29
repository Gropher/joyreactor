<?php

/**
 * BasePost
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $text
 * @property string $text_original
 * @property string $header
 * @property float $rating
 * @property integer $comments_count
 * @property float $mood
 * @property string $type
 * @property boolean $isNew
 * @property boolean $lj
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Blogs
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $Votes
 * @property Doctrine_Collection $Attributes
 * @property Doctrine_Collection $Attachments
 * @property Doctrine_Collection $BlogPosts
 * @property Doctrine_Collection $InFavorite
 * 
 * @method integer             getId()             Returns the current record's "id" value
 * @method integer             getUserId()         Returns the current record's "user_id" value
 * @method string              getText()           Returns the current record's "text" value
 * @method string              getTextOriginal()   Returns the current record's "text_original" value
 * @method string              getHeader()         Returns the current record's "header" value
 * @method float               getRating()         Returns the current record's "rating" value
 * @method integer             getCommentsCount()  Returns the current record's "comments_count" value
 * @method float               getMood()           Returns the current record's "mood" value
 * @method string              getType()           Returns the current record's "type" value
 * @method boolean             getIsNew()          Returns the current record's "isNew" value
 * @method boolean             getLj()             Returns the current record's "lj" value
 * @method sfGuardUser         getUser()           Returns the current record's "User" value
 * @method Doctrine_Collection getBlogs()          Returns the current record's "Blogs" collection
 * @method Doctrine_Collection getComments()       Returns the current record's "Comments" collection
 * @method Doctrine_Collection getVotes()          Returns the current record's "Votes" collection
 * @method Doctrine_Collection getAttributes()     Returns the current record's "Attributes" collection
 * @method Doctrine_Collection getAttachments()    Returns the current record's "Attachments" collection
 * @method Doctrine_Collection getBlogPosts()      Returns the current record's "BlogPosts" collection
 * @method Doctrine_Collection getInFavorite()     Returns the current record's "InFavorite" collection
 * @method Post                setId()             Sets the current record's "id" value
 * @method Post                setUserId()         Sets the current record's "user_id" value
 * @method Post                setText()           Sets the current record's "text" value
 * @method Post                setTextOriginal()   Sets the current record's "text_original" value
 * @method Post                setHeader()         Sets the current record's "header" value
 * @method Post                setRating()         Sets the current record's "rating" value
 * @method Post                setCommentsCount()  Sets the current record's "comments_count" value
 * @method Post                setMood()           Sets the current record's "mood" value
 * @method Post                setType()           Sets the current record's "type" value
 * @method Post                setIsNew()          Sets the current record's "isNew" value
 * @method Post                setLj()             Sets the current record's "lj" value
 * @method Post                setUser()           Sets the current record's "User" value
 * @method Post                setBlogs()          Sets the current record's "Blogs" collection
 * @method Post                setComments()       Sets the current record's "Comments" collection
 * @method Post                setVotes()          Sets the current record's "Votes" collection
 * @method Post                setAttributes()     Sets the current record's "Attributes" collection
 * @method Post                setAttachments()    Sets the current record's "Attachments" collection
 * @method Post                setBlogPosts()      Sets the current record's "BlogPosts" collection
 * @method Post                setInFavorite()     Sets the current record's "InFavorite" collection
 * 
 * @package    Empaty
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePost extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('post');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 4,
             ));
        $this->hasColumn('text', 'string', 2147483647, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2147483647,
             ));
        $this->hasColumn('text_original', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));
        $this->hasColumn('header', 'string', 2147483647, array(
             'type' => 'string',
             'length' => 2147483647,
             ));
        $this->hasColumn('rating', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('comments_count', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             'length' => 4,
             ));
        $this->hasColumn('mood', 'float', null, array(
             'type' => 'float',
             'default' => 0,
             ));
        $this->hasColumn('type', 'string', 255, array(
             'type' => 'string',
             'default' => 'post',
             'length' => 255,
             ));
        $this->hasColumn('isNew', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('lj', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('user_id', array(
             'fields' => 
             array(
              0 => 'user_id',
             ),
             'type' => NULL,
             ));
        $this->index('rating', array(
             'fields' => 
             array(
              0 => 'rating',
             ),
             'type' => NULL,
             ));
        $this->index('comments_count', array(
             'fields' => 
             array(
              0 => 'comments_count',
             ),
             'type' => NULL,
             ));
        $this->index('mood', array(
             'fields' => 
             array(
              0 => 'mood',
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
        $this->index('isNew', array(
             'fields' => 
             array(
              0 => 'isNew',
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
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));

        $this->hasMany('Blog as Blogs', array(
             'refClass' => 'BlogPost',
             'local' => 'post_id',
             'foreign' => 'blog_id'));

        $this->hasMany('PostComment as Comments', array(
             'local' => 'id',
             'foreign' => 'post_id'));

        $this->hasMany('PostVote as Votes', array(
             'local' => 'id',
             'foreign' => 'post_id'));

        $this->hasMany('PostAttribute as Attributes', array(
             'local' => 'id',
             'foreign' => 'post_id'));

        $this->hasMany('MessageAttachment as Attachments', array(
             'local' => 'id',
             'foreign' => 'message_id'));

        $this->hasMany('BlogPost as BlogPosts', array(
             'local' => 'id',
             'foreign' => 'post_id'));

        $this->hasMany('Favorite as InFavorite', array(
             'local' => 'id',
             'foreign' => 'post_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}