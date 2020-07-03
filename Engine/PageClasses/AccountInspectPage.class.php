<?php
namespace phramework;
use phramework;

/**
*
* AccountInspectPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountInspectPage extends BasePage
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
		$this->configName = "AccountInspectPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
		
		if (isset($_GET['c']))
		{
			$this->notifyPagelet("AccountInspectScreenPagelet", "loadAccountAdditive", $_GET['c']);
		}
		
	}
	
}