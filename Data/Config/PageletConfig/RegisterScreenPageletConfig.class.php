<?php
namespace phramework;
use phramework;

/**
*
* RegisterScreenPageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class RegisterScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "RegisterScreenPagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['LangRegister'] 	= 'register';
		$this->languageNames['LangUsername'] 	= 'username';
		$this->languageNames['LangPassword'] 	= 'password';
		$this->languageNames['LangEmail'] 		= 'email';
		$this->languageNames['LangLanguage'] 	= 'language';
		
		parent::__construct();
	}
	
}