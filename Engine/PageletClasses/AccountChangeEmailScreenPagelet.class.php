<?php
namespace phramework;
use phramework;

/**
*
* AccountChangeEmailScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangeEmailScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "AccountChangeEmailScreenConfig";
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
	
		/*
		* ================================================================================
		*                                       PREPARE FORM DATA
		* ================================================================================
		*/
		
		// Value
		$valueEmailCurrent	= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "email");
		
		// Placeholder
		$placeholderEmail 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerEmail");
		
		// eMail
		if (isset($templateTokens['valueEmailNew']) && !empty($templateTokens['valueEmailNew'])) {
			$valueEmailNew = $templateTokens['valueEmailNew'];
		} else {
			$valueEmailNew = '';
		}
		
		/*
		* ================================================================================
		*                                       CREATE FORM
		* ================================================================================
		*/
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountChangeEmailPage');
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"emailCurrent", 	"email", 	$valueEmailCurrent, 	$placeholderEmail, '', false, true, false);
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"emailNew", 		"email", 	$valueEmailNew, 		$placeholderEmail, '', false, false, true);
		$this->core->notifyMediator("FormManager", "addFormSubmit", 		$this->core->notifyMediator("LanguageManager", "getLanguage", "changeEmail"), "button button-fill");
		
		$templateTokens['formHeader'] 				= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formFieldEmailCurrent'] 	= $this->core->notifyMediator("FormManager", "getFormField", "emailCurrent");
		$templateTokens['formFieldEmailNew'] 		= $this->core->notifyMediator("FormManager", "getFormField", "emailNew");
		$templateTokens['formSubmit'] 				= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formFooter'] 				= $this->core->notifyMediator("FormManager", "getFormFooter");
		
		return parent::buildTemplate($templateName, $templateTokens);
		
		
	}
	
}