<?php
namespace phramework;
use phramework;

/**
*
* AccountProfileScreenPageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountProfileScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountProfileScreenPagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['langUsername'] 	= 'username';
		$this->languageNames['langEmail'] 		= 'email';
		$this->languageNames['langPassword'] 	= 'password';
		$this->languageNames['langLanguage'] 	= 'language';
		$this->languageNames['langCreated'] 	= 'created';
		$this->languageNames['langLastlogin'] 	= 'lastlogin';
		$this->languageNames['langLastonline'] 	= 'lastonline';
				
		parent::__construct();
		
	}
	
}