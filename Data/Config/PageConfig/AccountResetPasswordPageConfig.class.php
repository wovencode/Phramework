<?php
namespace phramework;
use phramework;

/**
*
* AccountResetPasswordPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountResetPasswordPageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 			= "AccountResetPasswordPage";
		$this->accessLoggedIn 			= false;
		$this->accessLoggedOut			= true;
		$this->isCached 				= false;
		$this->redirectWhenLoggedIn 	= true;
		
		/*
		* Tokens
		*/
		$this->tokenNames['page-name'] = strtolower($this->templateName);
		
		/*
		* Pagelets
		*/
		$this->pageletNames =
		[
			'AccountResetPasswordScreenPagelet',
			'BottomNavbarPagelet',
			'ModalWindowPagelet'
		];
		
		parent::__construct();
					
	}
	
}