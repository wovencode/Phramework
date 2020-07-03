<?php
namespace phramework;
use phramework;

/**
*
* AccountRegisterPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountRegisterPageConfig extends BasePageConfig
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
		
		$this->templateName	 			= 'AccountRegisterPage';
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
			'RegisterScreenPagelet',
			'BottomNavbarPagelet',
		];
		
		parent::__construct(); // Required!
		
	}
	
}