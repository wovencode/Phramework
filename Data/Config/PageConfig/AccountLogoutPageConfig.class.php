<?php
namespace phramework;
use phramework;

/**
*
* AccountLogoutPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountLogoutPageConfig extends BasePageConfig
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
		
		$this->templateName	 		= "AccountLogoutPage";
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
			'BottomNavbarPagelet'
		];
		
		parent::__construct();
		
	}
	
}