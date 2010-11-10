<?php

require(dirname(__FILE__) . '/web-optimizer/web.optimizer.php');
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);

//enable Doctrine cache
$manager = Doctrine_Manager::getInstance();
$servers = array('host' => 'localhost', 'port' => 11211, 'persistent' => true);
//$cacheDriver = new Doctrine_Cache_Memcache(array('servers' => $servers, 'compression' => false));
$cacheDriver = new Doctrine_Cache_Apc();
$manager->setAttribute(Doctrine::ATTR_QUERY_CACHE, $cacheDriver);
$manager->setAttribute(Doctrine::ATTR_RESULT_CACHE, $cacheDriver);

sfContext::createInstance($configuration)->dispatch();
$web_optimizer->finish();