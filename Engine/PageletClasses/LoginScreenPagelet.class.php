<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class LoginScreenPagelet extends BasePagelet
{

	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "LoginScreenPageletConfig";
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
		
		$valueUsername 		= '';
		$valuePassword 		= '';
		$valueRememberMe 	= true;
		
		if (isset($templateTokens['valueRememberMe']))
			$valueRememberMe 	= $templateTokens['valueRememberMe'];
		
		// Placeholders
		$placeholderUsername 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerUsername");
		$placeholderPassword 	= $this->core->notifyMediator("LanguageManager", "getLanguage", "registerPassword");
	
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
	
		/*
		* ================================================================================
		*                                       CREATE FORM
		* ================================================================================
		*/
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'LoginPage');
		
		$this->core->notifyMediator("FormManager", "createForm", $link);
		
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"username", 	"text", 		$valueUsername, 		$placeholderUsername);
		$this->core->notifyMediator("FormManager", "addFormInputText", 		"password", 	"password", 	$valuePassword, 		$placeholderPassword);
		$this->core->notifyMediator("FormManager", "addFormInputCheckbox", 	"rememberme", 	$valueRememberMe);
		$this->core->notifyMediator("FormManager", "addFormSubmit", 		$this->core->notifyMediator("LanguageManager", "getLanguage", "login"), "button button-fill");
		
		$templateTokens['formHeader'] 			= $this->core->notifyMediator("FormManager", "getFormHeader");
		$templateTokens['formFieldUsername'] 	= $this->core->notifyMediator("FormManager", "getFormField", "username");
		$templateTokens['formFieldPassword'] 	= $this->core->notifyMediator("FormManager", "getFormField", "password");
		$templateTokens['formFieldRememberMe'] 	= $this->core->notifyMediator("FormManager", "getFormField", "rememberme");
		$templateTokens['formSubmit'] 			= $this->core->notifyMediator("FormManager", "getFormSubmit");
		$templateTokens['formFooter'] 			= $this->core->notifyMediator("FormManager", "getFormFooter");
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
}