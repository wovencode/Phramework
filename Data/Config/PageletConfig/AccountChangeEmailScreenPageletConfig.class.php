<?php
namespace phramework;
use phramework;

/**
*
* AccountChangeEmailScreenConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangeEmailScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "AccountChangeEmailScreenPagelet";
		
		
		/*
		* Languages
		*/
		$this->languageNames['LangChangeEmail'] 	= 'changeEmail';
		$this->languageNames['LangEmail'] 			= 'email';
		$this->languageNames['LangCurrent'] 		= 'current';
		$this->languageNames['LangNew'] 			= 'new';
		
		parent::__construct();
		
	}
	
}