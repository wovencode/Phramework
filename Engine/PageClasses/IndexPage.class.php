<?php
namespace phramework;
use phramework;

/**
*
* IndexPage
*
* @author Fhiz
* @version 1.0
*
*/
class IndexPage extends BasePage
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
		$this->configName = "IndexPageConfig";
		
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