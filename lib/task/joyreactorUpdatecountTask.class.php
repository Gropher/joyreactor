<?php

class joyreactorUpdatecountTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'joyreactor';
    $this->name             = 'update-count';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [joyreactor:update-count|INFO] task does things.
Call it with:

  [php symfony joyreactor:update-count|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // Доктрина не переваривает данный запрос - будет переваривать только с версии 2.0. Поэтому пусть будет так
    $query = 'UPDATE blog b LEFT JOIN 
      (SELECT blog_post.blog_id, count(blog_post.id) as cnt
        FROM blog_post
        LEFT JOIN post ON post.id=blog_post.post_id
        WHERE post.type="post"
        GROUP BY blog_post.blog_id
      ) b2 ON b.id = b2.blog_id
      SET b.count = b2.cnt ';
    Doctrine_Manager::connection()->execute($query);
  }
}
