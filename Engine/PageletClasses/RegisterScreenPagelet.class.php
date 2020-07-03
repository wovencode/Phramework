<?php
namespace phramework;
use phramework;

/**
*
* RegisterScreenPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class RegisterScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "RegisterScreenPageletConfig";
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
		
		$languages = $this->core->notifyMediator("LanguageManager", "getLanguages");
		
		$valueUsername 		= '';
		$valuePassword 		= '';
		$valueEmail 		= '';
		
		// Placeholders
		$placeholderUsername 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerUsername");
		$placeholderPassword 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerPassword");
		$placeholderEmail 		= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerEmail");
		
		// Username
		if (isset($templateTokens['valueUsername']) && !empty($templateTokens['valueUsername'])) {
			$valueUsername = $templateTokens['valueUsername'];
		} else {
			$valueUsername = '';
		}
		
		// Password
		if (isset($templateTokens['valuePassword']) && !empty($templateTokens['valuePassword'])) {
			$valuePassword = $templateTokens['valuePassword'];
		} else {
			$valuePassword = '';
		}
		
		// eMail
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
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'RegisterPage', false);
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"username", 	"text", 		$valueUsername, 	$placeholderUsername);
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"password", 	"password", 	$valuePassword, 	$placeholderPassword);
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"email", 		"email", 		$valueEmail, 		$placeholderEmail);
		$this->core->notifyMediator("FormManager", "addFormInputSelect", 	"language", 	$languages, 	$this->core->notifyMediator("LanguageManager", "getCurrentLanguage"));
		$this->core->notifyMediator("FormManager", "addFormSubmit", 		$this->core->notifyMediator("LanguageManager", "getLanguage", "register"), "button button-fill");
		
		$templateTokens['formHeader'] 			= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formFieldUsername'] 	= $this->core->notifyMediator("FormManager", "getFormField", "username");
		$templateTokens['formFieldPassword'] 	= $this->core->notifyMediator("FormManager", "getFormField", "password");
		$templateTokens['formFieldEmail'] 		= $this->core->notifyMediator("FormManager", "getFormField", "email");
		$templateTokens['formFieldLanguage'] 	= $this->core->notifyMediator("FormManager", "getFormField", "language");
		$templateTokens['formSubmit'] 			= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formFooter'] 			= $this->core->notifyMediator("FormManager", "getFormFooter");
	
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}