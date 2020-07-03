<?php
namespace phramework;
use phramework;

/**
*
* AccountChangePasswordScreenPageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangePasswordScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountChangePasswordScreenPagelet";
		
		/*
		* Languages
		*/
		
		/*
		* Languages
		*/
		$this->languageNames['LangChangePassword'] 	= 'changePassword';
		$this->languageNames['LangPassword'] 		= 'password';
		$this->languageNames['LangCurrent'] 		= 'current';
		$this->languageNames['LangNew'] 			= 'new';
		
		parent::__construct();
		
	}
	
}