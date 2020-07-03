<?php
namespace phramework;
use phramework;

/**
*
* AccountInspectScreenPageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountInspectScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountInspectScreenPagelet";
		
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