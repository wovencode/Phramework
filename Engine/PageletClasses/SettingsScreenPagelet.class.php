<?php
namespace phramework;
use phramework;

/**
*
* SettingsScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class SettingsScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "SettingsScreenPageletConfig";
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
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountSettingsPage', false);
		
		$templateTokens['settingsNote'] = '';
		
		$disabled = false;
		
		if (!$this->core->notifyMediator("AccountManager", 'getAccountDatabaseData', 0, 'confirmed')) {
			$templateTokens['settingsNoteConfirmed'] = $this->core->notifyMediator("LanguageManager", "getLanguage", "unconfirmed");
			$templateTokens['settingsNote'] = $this->core->notifyMediator("LanguageManager", "getLanguage", 'infoConfirm');
			$disabled = true;
		} else {
			$templateTokens['settingsNoteConfirmed'] = $this->core->notifyMediator("LanguageManager", "getLanguage", "confirmed");
		}
			
		if (!$this->core->notifyMediator("AccountManager", 'checkRiskyAction', 0)) {
		
			$delay = $this->core->notifyMediator("AccountManager", "getRiskyActionDelay");
			
			if ($delay <= 1)
				$templateTokens['settingsNote'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", 'timeWaitMinute'), $delay);
			else
				$templateTokens['settingsNote'] = sprintf($this->core->notifyMediator("LanguageManager", "getLanguage", 'timeWaitMinutes'), $delay);
			
			$disabled = true;
			
		}
				
		/*
		* ================================================================================
		*                             CREATE LINKED SETTINGS BUTTONS
		* ================================================================================
		*/
		
		/*
		* @parameter NavigationSlot navigationSlot
		*/
		foreach ($this->config->data as $navigationSlot)
		{
			
			/*
			* initialize the button
			*/
			$navigationSlot->initialize($this->core);
		
			/*
			* Check if the button is enabled, according to login status
			*/
		
			if (!$this->core->notifyMediator("AccountManager", "checkAccess", 0, $navigationSlot->getLoggedIn(), $navigationSlot->getLoggedOut(), $navigationSlot->getConfirmed(), $navigationSlot->getUnconfirmed(), $navigationSlot->getRiskyAction(), $navigationSlot->getMinAdminLevel() ))
				$navigationSlot->toggleDisabled();
		
			/*
			* parse the button data into the template parameters
			*/
			$tokens = $navigationSlot->getTemplateTokens();
		
			$templateTokens[$navigationSlot->getToken()] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $navigationSlot->getTemplate(), $tokens, $this->config::CONST_SLOT);
	
		}
		
		/*
		* ================================================================================
		*                             	CREATE AVATAR UPLOAD
		* ================================================================================
		*/
		
		$this->core->notifyMediator("FormManager", "createForm", $link, '', 'multipart/form-data');
		$this->core->notifyMediator("FormManager", "addFormInputHidden", 'MAX_FILE_SIZE', $this->core->notifyMediator("InputManager", "getMaxFileSize"));
		$this->core->notifyMediator("FormManager", "addFormInputText", 'avatar', 'file', '', '', '', true, $disabled, false);
		$this->core->notifyMediator("FormManager", "addFormSubmit", $this->core->notifyMediator("LanguageManager", "getLanguage", "submit"), "button button-fill");
		
		$templateTokens['formAvatarHeader'] 			= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formAvatarFieldMaxFileSize'] 	= $this->core->notifyMediator("FormManager", "getFormField", 'MAX_FILE_SIZE');
		$templateTokens['formAvatarFieldAvatar'] 		= $this->core->notifyMediator("FormManager", "getFormField", 'avatar');
		$templateTokens['formAvatarSubmit'] 			= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formAvatarFooter'] 			= $this->core->notifyMediator("FormManager", "getFormFooter");
		
		/*
		* ================================================================================
		*                             CREATE LANGUAGE DROPDOWN
		* ================================================================================
		*/
		
		$languages = $this->core->notifyMediator("LanguageManager", "getLanguages");
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		$this->core->notifyMediator("FormManager", "addFormInputSelect", "language", $languages, $this->core->notifyMediator("LanguageManager", "getCurrentLanguage"), '', true);
		$this->core->notifyMediator("FormManager", "addFormSubmit", $this->core->notifyMediator("LanguageManager", "getLanguage", "submit"), "button button-fill");
		
		$templateTokens['formLangHeader'] 			= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formLangFieldLanguage'] 	= $this->core->notifyMediator("FormManager", "getFormField", "language");
		$templateTokens['formLangSubmit'] 			= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formLangFooter'] 			= $this->core->notifyMediator("FormManager", "getFormFooter");
	
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}