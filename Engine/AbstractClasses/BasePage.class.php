<?php
namespace phramework;
use phramework;

/**
*
* BasePage
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BasePage extends BaseParseable
{

	protected array $templateTokens = array();
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		parent::__construct($core);
		
		$this->directoryName = $this->config::CONST_PAGE;
		
		self::initializePagelets();
	}
	
	/**
	*
	* displayPage
	*
	* Displays the assembled page by output to the client
	*
	*/
	public function displayPage()
	{
		
		if ($this->canDisplay()) {
		
			/*
			*
			*/
			if ($this->config->redirectWhenLoggedIn == true) {
				if ($this->core->notifyMediator("AccountManager", "checkAccountValid", 0)) {
					Tools::redirect($this->core->notifyMediator("RouterManager", "getRouteLink", 'HomePage'));
				}
			}
			
			/*
			*
			*/
			static::processPage();
			#self::initializePagelets();
			echo $this->getTemplate($this->getName(), $this->templateTokens);
			exit();
			
		} else {
			
			/*
			*
			*/
			Tools::redirect($this->core->notifyMediator("RouterManager", "getRouteLink", "AccessDeniedPage"));
			
		}
	}
	
	/**
	*
	* processPage (Abstract)
	*
	*/
	public abstract function processPage();
	
}