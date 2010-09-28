<?php

/**
 * rss actions.
 *
 * @package    Empaty
 * @subpackage rss
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class rssActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(sfConfig::get('app_sitename'));
    $feed->setLink(url_for('@homepage', 'absolute=true'));
    $feed->setAuthorEmail('rss@joyreactor.ru');
    $feed->setAuthorName(sfConfig::get('app_sitename'));

    $this->setPosts($feed, Post::getRssLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeBest(sfWebRequest $request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(__('Лучшее').'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('@homepage', 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName(sfConfig::get('app_sitename'));

    $this->setPosts($feed, Post::getBestLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeWorst(sfWebRequest $request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(__('Худшее').'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('@homepage', 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName(sfConfig::get('app_sitename'));

    $this->setPosts($feed, Post::getWorstLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeMood(sfWebRequest $request)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    if($request->getParameter('mood') == 1)
        $feed->setTitle(__('Веселое').'/'.sfConfig::get('app_sitename'));
    elseif($request->getParameter('mood') == -1)
        $feed->setTitle(__('Грустное').'/'.sfConfig::get('app_sitename'));
    else
        $feed->setTitle(__('Интересное').'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('@homepage', 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName(sfConfig::get('app_sitename'));

    $this->setPosts($feed, Post::getMoodLine($request->getParameter('mood')));
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeBlog(sfWebRequest $request)
  {
    $blog = Doctrine::getTable('Blog')->find(array($request->getParameter('id')));
    $this->forward404Unless($blog);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle($blog->getName().'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('blog/show?id='.$blog->getId(), 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName($blog->getName());

    $this->setPosts($feed, $blog->getLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeUserblog(sfWebRequest $request)
  {
    $blog = Doctrine::getTable('Blog')->find(array($request->getParameter('id')));
    $this->forward404Unless($blog);
    $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forward404Unless($user);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle($blog->getName().'/'.$user->getUsername().'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('blog/user?id='.$blog->getId()."&username=".$user->getUsername(), 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName($blog->getName());

    $this->setPosts($feed, $blog->getUserLine($user));
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeUser(sfWebRequest $request)
  {
    $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forward404Unless($user);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle($user->getUsername().'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('post/user?username='.$user->getUsername(), 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName($user->getUsername());

    $this->setPosts($feed, $user->getLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeFriends(sfWebRequest $request)
  {
    $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forward404Unless($user);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(__('Френдлента').'/'.$user->getUsername().'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('post/friends?username='.$user->getUsername(), 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName($user->getUsername());

    $this->setPosts($feed, $user->getFriendsLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeLine(sfWebRequest $request)
  {
    $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forward404Unless($user);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(__('Лента').'/'.$user->getUsername().'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('post/personal?username='.$user->getUsername(), 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName($user->getUsername());

    $this->setPosts($feed, $user->getPersonalLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  public function executeDiscussion(sfWebRequest $request)
  {
    $user = sfGuardUser::getUserByUsername($request->getParameter('username'));
    $this->forward404Unless($user);

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N','Url'));
    $feed = new sfRssFeed();
    $feed->setTitle(__('Обсуждаемое').'/'.sfConfig::get('app_sitename'));
    $feed->setLink(url_for('post/duscussion', 'absolute=true'));
    $feed->setAuthorEmail(sfConfig::get('app_rss_editor'));
    $feed->setAuthorName(sfConfig::get('app_sitename'));

    $this->setPosts($feed, $user->getDiscussionLine());
    return $this->renderPartial('feed', array('feed' => $feed));
  }

  private function setPosts(&$feed, $posts)
  {
        foreach($posts as $post)
        {
            $item = new sfFeedItem();
            $item->setTitle(__('Пост №').$post->getId());
            $item->setLink('post/show?id='.$post->getId());
            $item->setAuthorName($post->getUser()->getUsername());
            $item->setPubdate(strtotime($post->getCreatedAt()));
            $item->setUniqueId($post->getId());
            $item->setDescription($this->getPartial('post/post_rss', array('post' => $post)));

            $feed->addItem($item);
        }
  }
}