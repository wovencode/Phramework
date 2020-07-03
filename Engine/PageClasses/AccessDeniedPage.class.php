<?php
namespace phramework;
use phramework;

/**
*
* AccessDeniedPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccessDeniedPage extends BasePage
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccessDeniedPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
	
		/*
		* TEMPLATE
		*/
		
		$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','accessDenied', 'loginToContinue', $this->config->slotNameFailure);
		
		
	}
	
}