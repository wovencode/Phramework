<?php
namespace phramework;
use phramework;

/**
*
* AccountLoginPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountLoginPageConfig extends BasePageConfig
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
		
		$this->templateName	 			= 'AccountLoginPage';
		$this->accessLoggedIn 			= true;
		$this->accessLoggedOut			= true;
		$this->isCached 				= false;
		$this->redirectWhenLoggedIn 	= true;
		
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
			'LoginScreenPagelet',
			'BottomNavbarPagelet',
		];
		
		parent::__construct();
		
	}
	
}