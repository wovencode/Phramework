<?php
namespace phramework;
use phramework;

/**
*
* AccountLogoutPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountLogoutPage extends BasePage
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccountLogoutPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
		
		/*
		* Logout the Account
		*/
		if ($this->core->notifyMediator("AccountManager", "logoutAccount", 0)) {
		
			/*
			* When successful, redirect to index
			*/
			Tools::redirect($this->core->notifyMediator("RouterManager", "getRouteLink", 'IndexPage'));
			
		}
		
	}
		
}