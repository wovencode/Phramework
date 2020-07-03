<?php
namespace phramework;
use phramework;

/**
*
* IndexPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class IndexPageConfig extends BasePageConfig
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
		
		$this->templateName	 			= "IndexPage";
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
			'TopCurrencyBarPagelet',
			'WelcomeScreenPagelet',
			'BottomNavbarPagelet',
		];
		
		parent::__construct();
		
	}
	
}