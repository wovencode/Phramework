<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class AccountProfileScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "AccountProfileScreenPageletConfig";
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
		
		
		// Username
		$this->templateTokens['username'] 			= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "name");
		
		// eMail
		$this->templateTokens['email'] 				= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "email");
		
		if ($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "confirmed"))
		{
			$this->templateTokens['labelFooterConfirmed'] = $this->core->notifyMediator("LanguageManager", "getLanguage", "confirmed");
		} else {
			$this->templateTokens['labelFooterConfirmed'] = $this->core->notifyMediator("LanguageManager", "getLanguage", "unconfirmed");
		}	
		
		// Password
		$this->templateTokens['password'] 			= Tools::maskString($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "passwordHash"));
		
		// Language
		$this->templateTokens['language'] 			= $this->core->notifyMediator("LanguageManager", "getCurrentLanguageName");
		
		// Created
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "created");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['created'] 			= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterCreated'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterCreated'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
		
		// Lastlogin
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "lastlogin");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['lastlogin'] 			= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterLastlogin'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterLastlogin'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
				
		// Lastonline
		$time = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "lastonline");
		$days = max(1, Tools::getFullDays($time));
		
		$this->templateTokens['lastonline'] 		= $time;
		
		if ($days <= 1)
			$this->templateTokens['labelFooterLastonline'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDayAgo"), $days);
		else
			$this->templateTokens['labelFooterLastonline'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", "timeDaysAgo"), $days);
				
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}