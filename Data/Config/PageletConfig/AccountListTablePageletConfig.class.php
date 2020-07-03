<?php
namespace phramework;
use phramework;

/**
*
* AccountListTablePageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountListTablePageletConfig extends BasePageletConfig
{

	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountListTablePagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['LangOf'] 		= 'adverbOf';
		$this->languageNames['LangPage']	= 'substantivePage';
		
		
		
		parent::__construct();
	}
	
}