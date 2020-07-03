<?php
namespace phramework;
use phramework;

/**
*
* AccountConfirmPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountConfirmPageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccountConfirmPage";
		$this->slotName				= 'F7Icon.slot';
		$this->accessLoggedIn 		= true;
		$this->accessLoggedOut		= false;
		$this->isCached 			= false;
		$this->accessUnconfirmed	= true;
		$this->accessConfirmed		= false;
		
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