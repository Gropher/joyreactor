<?php
/*
 * This file is part of the sfSmarty Plugin
 * (c) 2008 Jesse Badwal <jesse@insaini.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfSmarty
 *
 * @package sfSmartyPlugin
 * @subpackage lib
 * @author Jesse Badwal <jesse@insaini.com>
 * @version SVN: $Id: sfSmarty.class.php 11783 2008-09-25 16:21:27Z insaini $
 **/
class sfSmarty {

	/**
	 * Smarty instance 
	 *
	 * @var Smarty
	 */
    protected static $smarty = null;
  	protected static $templateSecurity = false;
  	protected static $cache;
  	protected static $log;
  	
  	protected static $loadedHelpers;
    protected static $knownFunctions;
    
    /**
     * sfSmarty constructor
     *
     **/
    final private function __construct()
    {
    }
        
    /**
     * Get the instance of sfSmarty
     * 
     * @return sfSmarty
     */
    public static function getInstance()
    {
        static $instance;
        
        if (is_null($instance)) {
        	$instance = new sfSmarty();
    		
       		if (!self::$log) {
            	self::$log = sfConfig::get('sf_logging_enabled')? sfContext::getInstance()->getLogger() : false;
    		}        	
    		if (!self::$cache) {
            	self::$cache = new sfFileCache(array('cache_dir' => sfConfig::get('sf_cache_dir')));
    		}
    		if (!self::$smarty) {
    			self::$smarty = $instance->getSmarty();
    		}
        }
        return $instance;
    }
    
    /**
    * sfSmarty::getSmarty()
    *
    * @return Smarty object
	* @access public
    **/
    public function getSmarty()
    {           
		if (!self::$smarty) {
			// get the path and instantiate the smarty object
			$smartyClassPath = sfConfig::get('app_sfSmarty_class_path', 'Smarty');
			if (substr($smartyClassPath, -1) != DIRECTORY_SEPARATOR) {
				$smartyClassPath .= DIRECTORY_SEPARATOR;
			}

			require_once(dirname(__FILE__).'/../../../'.$smartyClassPath . 'Smarty.class.php');
			self::$smarty = new Smarty();

			// set the smarty cache directory
			$smartyDirs = sfConfig::get('app_sfSmarty_cache_dir' , sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . 'Smarty');
			if (substr($smartyDirs, -1) != DIRECTORY_SEPARATOR) {
				$smartyDirs .= DIRECTORY_SEPARATOR;
			}
			self::$smarty->compile_dir = $smartyDirs . 'templates_c';
			self::$smarty->cache_dir = $smartyDirs . 'cache';
			self::$templateSecurity = sfConfig::get('app_sfSmarty_template_security', false);
			self::$smarty->security = self::$templateSecurity;
			if (!file_exists(self::$smarty->compile_dir)) {
				if (!mkdir(self::$smarty->compile_dir, 0777, true)) {
					throw new sfCacheException('Unable to create cache directory "' . self::$smarty->compile_dir . '"');
				}
				if (self::$log) self::$log->info(sprintf('{sfSmarty} creating compile directory: %s', self::$smarty->compile_dir));				
			}
			if (!file_exists(self::$smarty->cache_dir)) {
				if (!mkdir(self::$smarty->cache_dir, 0777, true)) {
					throw new sfCacheException('Unable to create cache directory "' . self::$smarty->cache_dir . '"');
				}
				if (self::$log) self::$log->info(sprintf('{sfSmarty} creating cache directory: %s', self::$smarty->cache_dir));
			}
			self::$smarty->register_compiler_function('use', array($this, 'smartyCompilerfunctionUse'));
			self::$smarty->register_postfilter(array('sfSmarty', 'smartyPostFilter'));
		}			
		return self::$smarty;
   	}
   	
   	/**
   	 * Escapes smarty stored vars for sfData
   	 *
   	 * @param sfSmartyView $view
   	 * @param integer $escaping
   	 * @return sfOutputEscaper
   	 */
   	private function getSfData($view, $escaping = ESC_RAW) 
   	{
   		$current_sf_data = self::$smarty->get_template_vars('sf_data');
		if (!empty($current_sf_data) && $view->getAttribute('sf_type') == 'partial') {
			if (isset($current_sf_data['sf_content'])) {
				$view->getAttributeHolder()->set('sf_content',$current_sf_data['sf_content']);
			}
		} 
		return sfOutputEscaper::escape($escaping, $view->getAttributeHolder()->getAll());
   	}
   	
    /**
    * sfSmarty::renderFile()
    * render template file using Smarty
    *
    * @param sfSmartyView $view
    * @param mixed $file
    * @return 
	* @access protected
    **/
	public function renderFile($view, $file)
	{
		$sf_context = sfContext::getInstance();
		$sf_request = $sf_context->getRequest(); 
		$sf_params = $sf_request->getParameterHolder();
		$sf_user = $sf_context->getUser();
		
		if ($view->getAttribute('sf_type') == 'layout') {
			self::$smarty->compile_id = $view->getDecoratorTemplate();				
		} else {
			self::$smarty->compile_id = $view->getModuleName();
		}
		
		$this->loadCoreAndStandardHelpers();
		
		$_escaping = $view->getAttributeHolder()->getEscaping();
		if ($_escaping === true || $_escaping == 'on') {
			$sf_data = $this->getSfData($view, $view->getAttributeHolder()->getEscapingMethod());
		} elseif ($_escaping === false || $_escaping == 'off') {
			$sf_data = $this->getSfData($view);
			$data = &$view->getAttributeHolder()->getAll();
			foreach ($data as $key => &$value) {
				self::$smarty->assign_by_ref($key, $value);
			}
		}	
		
		// we need to add the data to smarty
		self::$smarty->assign_by_ref('sf_data', $sf_data);			
		
		// we need to add the context to smarty
		self::$smarty->assign_by_ref('sf_context', $sf_context);
		
		// we need to add the request to smarty
		self::$smarty->assign_by_ref('sf_request', $sf_request);
		
		// we need to add the params to smarty
		self::$smarty->assign_by_ref('sf_params', $sf_params);
		
		// we need to add the user to smarty
		self::$smarty->assign_by_ref('sf_user', $sf_user);
		
		return self::$smarty->fetch("file:$file");       		
	}
	    
	/**
	 * sfSmarty::loadCoreAndStandardHelpers()
	 *
	 * @return
	 * @access protected
	 **/
	protected function loadCoreAndStandardHelpers()
	{
		$core_helpers = array('Helper', 'Url', 'Asset', 'Tag', 'Escaping', 'AppUrl');
		$standard_helpers = sfConfig::get('sf_standard_helpers');
		$helpers = array_unique(array_merge($core_helpers, $standard_helpers));
		foreach ($helpers as $helperName) {
			$this->loadHelper($helperName);
		}
		$smarty_helpers = sfConfig::get('sf_smarty_helpers');
		sfProjectConfiguration::getActive()->loadHelpers(array_unique(array_merge($helpers, $smarty_helpers)));
	}

	/**
	 * sfSmarty::loadHelper()
	 *
	 * @param mixed $helperName
	 * @return
	 * @access protected
	 **/
	protected function loadHelper($helperName)
	{
		if (!isset(self::$loadedHelpers[$helperName])) {
			if (!self::$cache->has($helperName)) {
				static $dirs;
				if (!is_array($dirs)) {	
					$dirs = sfProjectConfiguration::getActive()->getHelperDirs(/*$moduleName*/);
				}
				
				$fileName = $helperName . 'Helper.php';
				$path = '';
				foreach($dirs as $dir) {
					if (is_readable($dir . DIRECTORY_SEPARATOR . $fileName)) {
						$path = $dir . DIRECTORY_SEPARATOR . $fileName;
					    self::$cache->set($helperName, self::parseHelper($helperName, $path));
						break;
					}
				}
			}
			
			eval(self::$cache->get($helperName));
			self::$loadedHelpers[$helperName] = true;
		}
	}
	
	protected static function parseHelper($helperName, $path)
	{
		if (self::$log) self::$log->info('{sfSmarty} parsing helper: ' . $path . ' into the Smarty helper cache');	        
		$code = '';
		$lines = file($path);
		foreach($lines as $line) {
			$line = trim($line);
			if (strpos($line, 'function') === 0) {
				preg_match('/function\\s+(\\w+)\\s*\\((.*)\\)\\s*\\{?$/', $line, $matches);
				$name = $matches[1];
				if ($name{0} == '_' && $name !== '__') {
					continue;
				}
                 
				$code .= "\nself::\$knownFunctions['$name']=";
				if ($matches[2]) {
					$code .= var_export(self::parseArguments($matches[2]), true);
				} else {
					$code .= 'array()';
				}
				$code .= ";\nself::registerCompilerFunction('$name', array(\$this, '{$name}_CompilerFunction'));";
				$code .= ";\nself::registerModifier('$name', array(\$this, '{$name}_Modifier'));";				
			}
		}
		return $code;
	}

	/**
	 * sfSmarty::parseArguments()
	 *
	 * @param mixed $argumentString
	 * @return array
	 **/
	protected static function parseArguments($argumentString)
	{
		$ex_arg_str = explode(',',$argumentString);
		
		$args = array();
		foreach ($ex_arg_str as &$ex_arg) {
			$par = explode('=',$ex_arg);
			$key = trim($par[0]);
			if (count($par) === 1) {
				$args[$key] = array();	
				continue;
			}
			
			$val = trim($par[1]);
			$args[$key] = array('default' => $val);
		}
		return $args;
	}

	/**
	 * sfSmarty::smartyCompilerfunctionUse()
	 * this provides the use tag in smarty: {use helper="path"}
	 *
	 * @param mixed $content
	 * @param Smarty $smarty
	 * @return
	 **/
	public function smartyCompilerfunctionUse($content, Smarty $smarty)
	{
		if (!preg_match('/helper="([^"]+)"/', $content, $matches)) {
			throw new Exception('sfSmartyView: Cannot compile template. Use: {use helper="helpername"}');
		}
		$this->loadHelper($matches[1]);
		return '';
	}
	
	/**
	 * sfSmarty::smartyPostFilter()
	 *
	 * @param mixed $content
	 * @param Smarty $smarty
	 * @return
	 **/
	public static function smartyPostFilter($content, Smarty $smarty)
	{
		$helpers = '';
		if (count(self::$loadedHelpers)) {
			$helpers .= "use_helper('".implode("','",array_keys(self::$loadedHelpers))."');";
			$helpers = "<?php $helpers ?>";
		}
		return $helpers . $content;
	}

	/**
	 * sfSmarty::registerBlock()
	 * this is an access function to the internal smarty instance
	 * to register a block function
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerBlock($tag, $function)
	{
		self::$smarty->register_block($tag, $function);
	}

	/**
	 * sfSmarty::registerFunction()
	 * this is an access function to the internal smarty instance
	 * to register a function
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerFunction($tag, $function)
	{
		self::$smarty->register_function($tag, $function);
	}

    /**
     * sfSmarty::registerCompilerFunction()
     * this is an access function to the internal smarty instance
     * to register a compiler function
     *
     * @param mixed $tag
     * @param mixed $function
     * @return
     **/
    public static function registerCompilerFunction($tag, $function)
    {
        self::$smarty->register_compiler_function($tag, $function);
    }
          
	/**
	 * sfSmarty::registerModifier()
	 * this is an access function to the internal smarty instance
	 * to register a modifier
	 *
	 * @param mixed $tag
	 * @param mixed $function
	 * @return
	 **/
	public static function registerModifier($tag, $function)
	{
		self::$smarty->register_modifier($tag, $function);
	}   

	/**
	 * sfSmarty::__call()
	 * generic compiler function for all new tags
	 *
	 * @param mixed $functionName
	 * @param mixed $argsArray
	 * @return
	 **/
	public function __call($functionName, $argsArray)
	{		
		$return = '';
		if (strpos($functionName, '_Modifier') !== FALSE) {
			$return = call_user_func_array(str_replace('_Modifier', '', $functionName), $argsArray);
		} else if (strpos($functionName, '_CompilerFunction') !== FALSE) {
			if (!trim($argsArray[0]) || !is_object($argsArray[1])) {
				$args = array();
			} else {
				$args = $argsArray[1]->_parse_attrs($argsArray[0]);	
			}
			$return = $this->_processCompilerFunction(str_replace('_CompilerFunction', '', $functionName), $args);
		}
		return $return;		
	}
		
	/**
	 * sfSmarty::_processCompilerFunction()
	 *
	 * @param string $functionName
	 * @param array $args
	 * @return string
	 */
	private function _processCompilerFunction($functionName, $args) 
	{
		$argsOrder = $allArgs = (array)self::$knownFunctions[$functionName];
		$helperWithVarArgs = count($allArgs) == 0;
		$cacheArgs = array();
		foreach($args as $name => $value) {
			$name = '$' . trim($name);
			$value = trim($value);
			if (!isset($allArgs[$name]) && !$helperWithVarArgs) {
				throw new Exception('sfSmartyView: Cannot compile template. Unknown field found: "' . substr($name, 1) . '" near tag ' . $functionName);
			}
			$cacheArgs[$name] = $value;
			unset($allArgs[$name]);
		}
		foreach($allArgs as $name => $default) {
			if (!isset($default['default'])) {
				throw new Exception('sfSmartyView: Cannot compile template. Required field "' . substr($name, 1) . '" not found near tag ' . $functionName);
			}
			$cacheArgs[$name] = $default['default'];
		}
		$code = '';
		if (!$helperWithVarArgs) {
			foreach($argsOrder as $name => $value) {
				$code .= $code ? ',' : '';
				if (is_bool($value)) {
					$code .= $cacheArgs[$name]?'true':'false';
				} else {
					$code .= $cacheArgs[$name];
				}
			}
		} else {
			$code .= implode(',',array_values($cacheArgs));
		}
		return "echo $functionName($code);";		
	}
}
