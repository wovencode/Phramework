<?php
namespace phramework;
use phramework;

/**
*
* AccessDeniedPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccessDeniedPageConfig extends BasePageConfig
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccessDeniedPage";
		$this->slotName				= 'F7Icon.slot';
		$this->accessLoggedIn 		= false;
		$this->accessLoggedOut		= true;
		$this->accessConfirmed		= true;
		$this->accessUnconfirmed 	= true;
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
			'BottomNavbarPagelet',
			'ModalWindowPagelet'
		];
		
		parent::__construct();
					
	}
	
}