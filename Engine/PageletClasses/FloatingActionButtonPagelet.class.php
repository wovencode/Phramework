<?php
namespace phramework;
use phramework;

/**
*
* FloatingActionButtonPagelet
*
* The class file for the Floating Action Button (FAB) known from Android apps.
* FAB can be placed in 9 different locations on the screen and hovers above other elements.
* It comes with 15 different pre-defined background colors. The button opens/closes a floating
* context menu that contains customizeable links. Those links contain both a small icon as
* well as a text label.
*
* Learn more about the Framework7 FAB here:
* https://framework7.io/docs/floating-action-button.html
*
* @author Fhiz
* @version 1.0
*
*/
class FloatingActionButtonPagelet extends NavigationPagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "FloatingActionButtonPageletConfig";
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
	public function buildTemplate(string $templateName, array $templateTokens=array()) : string
	{
		
		
		$templateTokens['position'] 			= $this->config->position;
		$templateTokens['buttons-direction'] 	= $this->config->buttons_direction;
		$templateTokens['color'] 				= $this->config->color;
		$templateTokens['avatar'] 				= Tools::buildPublicPath($this->config::CONST_CDN_UPLOAD, $this->core->notifyMediator("AccountManager", 'getAccountDatabaseData', 0, 'avatar'), array($this->config::CONST_PUBLIC, $this->config::CONST_MEDIA, $this->config::CONST_AVATARS));
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}