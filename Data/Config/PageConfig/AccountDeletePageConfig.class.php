<?php
namespace phramework;
use phramework;

/**
*
* AccountDeletePageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountDeletePageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 			= "AccountDeletePage";
		$this->accessLoggedIn 			= true;
		$this->accessLoggedOut			= false;
		$this->isCached 				= false;
		$this->redirectWhenLoggedIn		= false;
		
		/*
		* Tokens
		*/
		$this->tokenNames['page-name'] = strtolower($this->templateName);
		
		/*
		* Pagelets
		*/
		$this->pageletNames =
		[
			'TopCurrencyBarPagelet',
			'BottomNavbarPagelet',
			'FloatingActionButtonPagelet',
			'ModalWindowPagelet'
		];
		
		parent::__construct();
					
	}
	
}