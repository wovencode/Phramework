<?php
namespace phramework;
use phramework;

/**
*
* InstallPageConfig
*
* @author Fhiz
* @version 1.0
*
*/
class InstallPageConfig extends BasePageConfig
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
    public function __construct()
	{
		
		$this->templateName	 			= "InstallPage";
		$this->accessLoggedIn 			= false;
		$this->accessLoggedOut			= true;
		$this->isCached 				= false;
		$this->redirectWhenLoggedIn 	= true;
		
		parent::__construct();
		
	}
	
}