<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
abstract class NavigationPagelet extends BasePagelet
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
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
		
		$templateTokens['slots'] = NULL;
		
		/*
		* @parameter NavigationSlot navigationSlot
		*/
		foreach ($this->config->data as $navigationSlot)
		{
		
			/*
			* Check if the slot can be displayed, according to login status
			*/
			
			if ($this->core->notifyMediator("AccountManager", "checkAccess", 0, $navigationSlot->getLoggedIn(), $navigationSlot->getLoggedOut(), $navigationSlot->getConfirmed(), $navigationSlot->getUnconfirmed(), $navigationSlot->getRiskyAction(), $navigationSlot->getMinAdminLevel()))
			{
				
				/*
				* initialize the slot
				*/
				$navigationSlot->initialize($this->core);
				
				/*
				* parse the slot data into the template parameters
				*/
				$tokens = $navigationSlot->getTemplateTokens();
				
				$templateTokens['slots'] .= $this->core->notifyMediator("TemplateManager", "parseTemplate", $navigationSlot->getTemplate(), $tokens, $this->config::CONST_SLOT);
			
			}

		}
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}

}