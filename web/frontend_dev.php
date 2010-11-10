<?php

// this check prevents access to debug front controllers that are deployed by accident to production servers.
// feel free to remove this, extend it or make something more sophisticated.
if (!in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')))
{
  //die('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'dev', true);

//enable Doctrine cache
$manager = Doctrine_Manager::getInstance();
$servers = array('host' => 'localhost', 'port' => 11211, 'persistent' => true);
//$cacheDriver = new Doctrine_Cache_Memcache(array('servers' => $servers, 'compression' => false));
$cacheDriver = new Doctrine_Cache_Apc();
$manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver);
$manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);

sfContext::createInstance($configuration)->dispatch();
