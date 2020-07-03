<?php
namespace phramework;
use phramework;

/**
*
* AccountChangePasswordScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangePasswordScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "AccountChangePasswordScreenPageletConfig";
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
		$valuePasswordCurrent	= $this->core->notifyMediator("AccountManager", "getAccountTemporaryData", 0, "password");
		
		// Placeholder
		$placeholderPassword 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerPassword");
		
		// Password
		if (isset($templateTokens['valuePasswordNew']) && !empty($templateTokens['valuePasswordNew'])) {
			$valuePasswordNew = $templateTokens['valuePasswordNew'];
		} else {
			$valuePasswordNew = '';
		}
		
		/*
		* ================================================================================
		*                                       CREATE FORM
		* ================================================================================
		*/
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountChangePasswordPage');
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"passwordCurrent", 	"password", 	$valuePasswordCurrent, 	$placeholderPassword);
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"passwordNew", 		"password", 	$valuePasswordNew, 		$placeholderPassword);
		$this->core->notifyMediator("FormManager", "addFormSubmit", 		$this->core->notifyMediator("LanguageManager", "getLanguage", "changePassword"), "button button-fill");
		
		$templateTokens['formHeader'] 					= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formFieldPasswordCurrent'] 	= $this->core->notifyMediator("FormManager", "getFormField", "passwordCurrent");
		$templateTokens['formFieldPasswordNew'] 		= $this->core->notifyMediator("FormManager", "getFormField", "passwordNew");
		$templateTokens['formSubmit'] 					= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formFooter'] 					= $this->core->notifyMediator("FormManager", "getFormFooter");
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}