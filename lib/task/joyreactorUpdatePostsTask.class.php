<?php

class joyreactorUpdatePostsTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'joyreactor';
    $this->name             = 'update-posts';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [joyreactor:update-count|INFO] task resaves post texts.
Call it with:

  [php symfony joyreactor:update-count|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $this->context = sfContext::createInstance($this->configuration);
    $this->context->getConfiguration()->loadHelpers(array('Parse','Text','Tag'));
    ini_set('memory_limit','2048M');

    Doctrine::getTable('Post')->createQuery()->update()->set('text_original', 'text')->where('text_original is NULL')->execute();
    Doctrine::getTable('PostComment')->createQuery()->update()->set('comment_original', 'comment')->where('comment_original is NULL')->execute();

    $offset = 0;
    do {
      $posts = Doctrine::getTable('Post')->createQuery()->limit(100)->offset($offset)->execute();
      $this->ParsePosts($posts);
      $offset+=100;
      echo "Offset: " . $offset . "\n";
    } while(count($posts));

    $offset = 0;
    do {
      $comments = Doctrine::getTable('PostComment')->createQuery()->limit(100)->offset($offset)->execute();
      $this->ParsetComments($comments);
      $offset+=100;
      echo "Comments Offset: " . $offset . "\n";
    } while(count($comments));
  }

  private function ParsetComments($comments)
  {
    foreach($comments as $comment)
    {
      $text = $comment->getCommentOriginal();
      if(!$text)
        continue;

      $parsed = parsetext($text);
      if($parsed != $comment->getComment())
      {
        echo "Comment " . $comment->getId() . " changed\n";
        $comment->setComment($parsed);
        $comment->save();
      }
    }
  }

  private function ParsePosts($posts)
  {
    foreach($posts as $post)
    {
      $text = $post->getTextOriginal();
      if(!$text)
        continue;

      $parsed = parsetext($text);
      if($parsed != $post->getText())
      {
        echo "Post " . $post->getId() . " changed\n";
        $post->setText($parsed);
        $post->save();
      }
    }
  }
}
