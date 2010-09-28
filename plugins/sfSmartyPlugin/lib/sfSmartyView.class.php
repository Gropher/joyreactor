<?php
/*
 * This file is part of the sfSmarty Plugin
 * (c) 2008 Jesse Badwal <jesse@insaini.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfSmartyView
 *
 * @package sfSmartyPlugin
 * @subpackage lib
 * @author Jesse Badwal <jesse@insaini.com>
 * @version SVN: $Id: sfSmartyView.class.php 11783 2008-09-25 16:21:27Z insaini $
 **/
class sfSmartyView extends sfPHPView {

	/**
	 * SfSmarty Instance
	 *
	 * @var sfSmarty
	 */
	protected static $smarty = null;
	
	/**
	 * sfSmartyView::initialize()
	 * This method is used instead of sfPHPView::initialze
	 *
	 * @param mixed $context
	 * @param mixed $moduleName
	 * @param mixed $actionName
	 * @param mixed $viewName
	 * @return
	 **/
	public function initialize($context, $moduleName, $actionName, $viewName)
	{
		$this->setExtension(sfConfig::get('app_sfSmarty_template_extension', '.tpl'));
		parent::initialize($context, $moduleName, $actionName, $viewName);
		self::$smarty = sfSmarty::getInstance();
		
		if (sfConfig::get('sf_logging_enabled')) {
			$this->dispatcher->notify(new sfEvent($this, 'application.log', array('{sfSmartyView} is used for rendering')));
		}
		return true;
	}

	/**
	 * sfSmartyView::getEngine()
	 * returns the sfSmarty instance
	 *
	 * @return sfSmarty instance
	 */
	public function getEngine()
	{
		return self::$smarty;
	}

	/**
	 * sfSmartyView::preRenderCheck()
	 *
	 * Does some logic to allow the use of both
	 * .php and smarty template files
	 *
	 * @see sfView::preRenderCheck()
	 **/
	protected function preRenderCheck()
	{
		try {
			parent::preRenderCheck();
		} 
		catch (sfRenderException $e) {
			$this->setTemplate(str_replace($this->getExtension(), '.php', $this->getTemplate()));
			$this->setExtension('.php');
			//parent::configure();
			parent::preRenderCheck();
		}
	}

	/**
	 * sfSmartyView::renderFile()
	 * this method is unsed instead of sfPHPView::renderFile()
	 *
	 * @param mixed $file
	 * @return
	 * @access protected
	 **/
	protected function renderFile($file)
	{	
		if ($this->getExtension() == '.php' && $this->getAttribute('sf_type') != 'layout') {
			return parent::renderFile($file);
		}
		
		if (sfConfig::get('sf_logging_enabled')) {
			$this->dispatcher->notify(new sfEvent($this, 'application.log', array('{sfSmartyView} renderFile '.$file)));
		}
		return $this->getEngine()->renderFile($this, $file);
	}

	/**
	 * sfSmartyView::registerBlock()
	 * this is an access function to the internal smarty instance
	 * to register a block function
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerBlock($tag, $function)
	{
		self::$smarty->registerBlock($tag, $function);
	}

	/**
	 * sfSmartyView::registerFunction()
	 * this is an access function to the internal smarty instance
	 * to register a function
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerFunction($tag, $function)
	{
		self::$smarty->registerFunction($tag, $function);
	}

	/**
	 * sfSmartyView::registerCompilerFunction()
	 * this is an access function to the internal smarty instance
	 * to register a compiler function
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerCompilerFunction($tag, $function)
	{
		self::$smarty->registerCompilerFunction($tag, $function);
	}

	/**
	 * sfSmartyView::registerModifier()
	 * this is an access function to the internal smarty instance
	 * to register a modifier
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerModifier($tag, $function)
	{
		self::$smarty->registerModifier($tag, $function);
	}
}
