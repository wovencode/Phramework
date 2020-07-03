<?php
namespace phramework;
use phramework;

/**
*
* InstallPage
*
* @author Fhiz
* @version 1.0
*
*/
class InstallPage extends BasePage
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
		$this->configName = "InstallPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
		if ($this->core->notifyMediator("InstallManager", "executeInstall"))
		{
		
			echo "Installing...";
		} else {
			echo "Installation failed!";
		}
		
	}
	
}