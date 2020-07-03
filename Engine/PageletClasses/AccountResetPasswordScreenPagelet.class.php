<?php
namespace phramework;
use phramework;

/**
*
* AccountResetPasswordScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class AccountResetPasswordScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "AccountResetPasswordScreenPageletConfig";
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
		
		$valueEmail 		= '';
		
		// Placeholder
		$placeholderEmail 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerEmail");
		
		// eMail Value
		if (isset($templateTokens['valueEmail']) && !empty($templateTokens['valueEmail'])) {
			$valueEmail = $templateTokens['valueEmail'];
		} else {
			$valueEmail = '';
		}

		/*
		* ================================================================================
		*                                       CREATE FORM
		* ================================================================================
		*/
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountResetPasswordPage');
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"email", 	"email", 		$valueEmail, 		$placeholderEmail);
		$this->core->notifyMediator("FormManager", "addFormSubmit", 		$this->core->notifyMediator("LanguageManager", "getLanguage", "forgotPassword"), "button button-fill");
		
		$templateTokens['formHeader'] 			= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formFieldEmail'] 		= $this->core->notifyMediator("FormManager", "getFormField", "email");
		$templateTokens['formSubmit'] 			= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formFooter'] 			= $this->core->notifyMediator("FormManager", "getFormFooter");
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}