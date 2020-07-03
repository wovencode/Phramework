<?php
namespace phramework;
use phramework;

/**
*
* HomePage
*
* @author Fhiz
* @version 1.0
*
*/
class HomePage extends BasePage
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
		$this->configName = "HomePageConfig";
		
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