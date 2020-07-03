<?php
namespace phramework;
use phramework;

/**
*
* AccountSettingsPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountSettingsPageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccountSettingsPage";
		$this->accessLoggedIn 		= true;
		$this->accessLoggedOut		= false;
		$this->isCached 			= false;
		
		/*
		* Tokens
		*/
		$this->tokenNames['page-name'] = strtolower($this->templateName);
		$this->tokenNames['page-content'] = "login-screen-content";
		
		/*
		* Pagelets
		*/
		$this->pageletNames =
		[
			'TopCurrencyBarPagelet',
			'BottomNavbarPagelet',
			'FloatingActionButtonPagelet',
			'SettingsScreenPagelet',
			'ModalWindowPagelet'
		];
		
		parent::__construct();
					
	}
	
}