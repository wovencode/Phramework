<?php
namespace phramework;
use phramework;

/**
*
* AccountProfilePageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountProfilePageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccountProfilePage";
		$this->accessLoggedIn 		= true;
		$this->accessLoggedOut		= false;
		$this->isCached 			= false;
		
		/*
		* Tokens
		*/
		$this->tokenNames['page-name'] = strtolower($this->templateName);
		
		/*
		* Pagelets
		*/
		$this->pageletNames =
		[
			'AccountProfileScreenPagelet',
			'TopCurrencyBarPagelet',
			'BottomNavbarPagelet',
			'FloatingActionButtonPagelet'
		];
		
		parent::__construct();
					
	}
	
}