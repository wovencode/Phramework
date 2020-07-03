<?php
namespace phramework;
use phramework;

/**
*
* TopCurrencyBarPagelet
*
* The config file for a Navbar as common in Android and iOS apps, its always located
* at the bottom of the screen and uses the theme's global background color. The Navbar
* contains links that are represented by a small icon as well as a text label.
*
* Learn more about the Framework7 component here:
* https://framework7.io/docs/toolbar-tabbar.html
*
* @author Fhiz
* @version 1.0
*
*/
class TopCurrencyBarPagelet extends NavigationPagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "TopCurrencyBarPageletConfig";
		parent::__construct($core);
	
	}
	
	/**
	*
	* buildTemplate (Overridden)
	*
	* Rebuilds the template from scratch and returns it.
	*
	* @param string $templateName
	* @param array $templateTokens
	* @return string
	*
	*/
	public function buildTemplate(string $templateName, array $templateTokens=NULL) : string
	{
		return parent::buildTemplate($templateName, $templateTokens);
	}
	
}