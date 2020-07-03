<?php
namespace phramework;
use phramework;

/**
*
* AccountListPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountListPageConfig extends BasePageConfig
{
	
	/*
	* Class Variables
	*/
	public bool $includeOwnAccount 	= false;
	public int $maxAccounts 		= 10;
	
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
	
		$this->templateName 		= "AccountListPage";
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
			'TopCurrencyBarPagelet',
			'BottomNavbarPagelet',
			'FloatingActionButtonPagelet',
			'AccountListTablePagelet'
		];
		
		parent::__construct();
					
	}
	
}