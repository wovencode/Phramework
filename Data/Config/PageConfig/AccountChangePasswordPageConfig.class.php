<?php
namespace phramework;
use phramework;

/**
*
* AccountChangePasswordPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangePasswordPageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccountChangePasswordPage";
		$this->accessLoggedIn 		= true;
		$this->accessLoggedOut		= false;
		$this->isCached 			= false;
		$this->accessUnconfirmed	= false;
		$this->accessConfirmed		= true;
		
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
			'AccountChangePasswordScreenPagelet',
			'ModalWindowPagelet'
		];
		
		parent::__construct();
					
	}
	
}