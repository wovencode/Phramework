<?php
namespace phramework;
use phramework;

/**
*
* AccountInspectScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class AccountInspectScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "AccountInspectScreenPageletConfig";
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
		
		// Avatar
		$avatar = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 1, "avatar");
		$this->templateTokens['avatar'] = Tools::buildPublicPath($this->config::CONST_CDN_UPLOAD, $avatar, array($this->config::CONST_PUBLIC, $this->config::CONST_MEDIA, $this->config::CONST_AVATARS));
		
		// Username
		$this->templateTokens['username'] 			= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 1, "name");
		
		// Language
		$this->templateTokens['language'] 			= $this->core->notifyMediator("LanguageManager", "getCurrentLanguageName");
		
		// Created
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 1, "created");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['created'] 			= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterCreated'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterCreated'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
		
		// Lastlogin
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 1, "lastlogin");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['lastlogin'] 			= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterLastlogin'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterLastlogin'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
				
		// Lastonline
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 1, "lastonline");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['lastonline'] 		= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterLastonline'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterLastonline'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
			
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
	/**
	*
	* loadAccountAdditive
	*
	*/
	public function loadAccountAdditive(string $uniqueId)
	{
	
		// Load Account Additive
		$this->core->notifyMediator("AccountManager", "loadAccountAdditive", 1, $uniqueId);
		
	}
	
}