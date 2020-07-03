<?php
namespace phramework;
use phramework;

/**
*
* ResetPasswordScreenPageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
class ResetPasswordScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountResetPasswordScreenPagelet";
		
		/*
		* Languages
		*/
		
		/*
		* Languages
		*/
		$this->languageNames['LangResetPassword'] 	= 'forgotPassword';
		$this->languageNames['LangEmail'] 			= 'email';
		
		parent::__construct();
		
	}
	
}