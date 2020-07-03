<?php
namespace phramework;
use phramework;

/**
*
* AccountProfilePage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountProfilePage extends BasePage
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
		$this->configName = "AccountProfilePageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
		
	}
	
}