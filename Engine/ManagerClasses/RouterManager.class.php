<?php
namespace phramework;
use phramework;

/**
*
* RouterManager
*
* @author Fhiz
* @version 1.0
*
*/
final class RouterManager extends BaseManager
{

	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "RouterManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	*/
	public function initializeLate() : void
	{
		$this->router();
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
	*
	* getRouteLink
	*
	*
	* 
	* @param string
	* @return string
	*
	*/
	public function getRouteLink(string $page, bool $includeRoot=true) : string
	{
		
		$key = array_search($page, $this->config->data);
		
		if ($key != false) {
			
			$key = "?" . $this->config::CONST_PAGE_VARIABLE . "=" . $key;
			
			if (!$includeRoot) {
				return $key;
			} else {
				return DIRECTORY_SEPARATOR . $this->config::CONST_ROOT . DIRECTORY_SEPARATOR . $key;
			}
			
		}
		
		return '';
		
	}
	
	/**
	*
	* getRoutePage
	*
	*
	* 
	* @param string
	* @return string
	*
	*/
	public function getRoutePage(string $key) : string
	{
		return $this->config->data[$key];
	}
	
	/**
	*
	* hasRoutePage
	*
	* @param string
	* @return bool
	*
	*/
	protected function hasRoutePage(string $page) : bool
	{
		return array_search($page, $this->config->data) != false;
	}
	
	/**
	*
	* hasRouteKey
	*
	* @param string
	* @return bool
	*
	*/
	protected function hasRouteKey(string $key) : bool
	{
		return array_key_exists($key, $this->config->data) != false;
	}
		
	/**
	*
	* router
	*
	*/
	protected function router() : void
	{
	
		$routeKey = NULL;
		
		/*
		* Set to default page by default
		*/
		$routePage = $this->config::CONST_DEFAULT_PAGE;
		
		/*
		* 'CONST_PAGE_VARIABLE' is provided by htaccess
		*/
		if (isset($_GET[$this->config::CONST_PAGE_VARIABLE])) {
			$routeKey = $_GET[$this->config::CONST_PAGE_VARIABLE];
		}
		
		/*
		* Check if route exists
		*/
		if ($routeKey != NULL && $this->hasRouteKey($routeKey)) {
			$routePage = $this->getRoutePage($routeKey);
		}
				
		/*
		* Route
		*/
		$className = __NAMESPACE__ . "\\" . $routePage;
		
		if (class_exists($className)) {
			$page = new $className($this->core);
			$page->displayPage();
			exit();
		} else {
			exit('[RouterManager] Page Class named "'.$className.'" does not exist.');
		}
		
	}
	
}