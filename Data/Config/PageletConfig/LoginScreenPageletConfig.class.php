<?php
namespace phramework;
use phramework;

/**
*
* LoginScreenConfig
*
* @author Fhiz
* @version 1.0
*
*/
class LoginScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "LoginScreenPagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['LangLogin'] 		= 'login';
		$this->languageNames['LangUsername'] 	= 'username';
		$this->languageNames['LangPassword'] 	= 'password';
		$this->languageNames['LangRememberMe'] 	= 'rememberMe';
				
		parent::__construct();
		
	}
	
}