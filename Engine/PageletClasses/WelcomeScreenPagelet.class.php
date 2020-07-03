<?php
namespace phramework;
use phramework;

/**
*
* WelcomeScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class WelcomeScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "WelcomeScreenPageletConfig";
		parent::__construct($core);
	
	}
	
	/**
	*
	* buildTemplate (Overridden)
	*
	* Rebuilds the template from scratch and returns it.
	*
	* @param array $templateTokens
	* @return string
	*
	*/
	public function buildTemplate(string $templateName, array $templateTokens=array()) : string
	{
	
		
	
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}