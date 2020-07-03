<?php
namespace phramework;
use phramework;

/**
*
* AccountLoginPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountLoginPage extends BasePage
{
	
	/*
	* Class Variables
	*/
	protected array $accountData = array();
	
	protected bool $validUsername 	= false;
	protected bool $validPassword 	= false;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		$this->accountData['name'] 			= '';
		$this->accountData['password'] 		= '';
		$this->accountData['rememberMe'] 	= true;
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccountLoginPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{

		/*
		* 1) DATA
		*/
		
		/*
		* Userame
		*/
		if (isset($_POST['username'])) {
			$this->accountData['name'] = $_POST['username'];
			$this->validUsername = $this->core->notifyMediator("AccountManager", "validateUsername", $_POST['username']);
		}
			
		/*
		* Password
		*/
		if (isset($_POST['password'])) {
			$this->accountData['password'] = $_POST['password'];
			$this->validPassword = $this->core->notifyMediator("AccountManager", "validatePassword", $_POST['password']);
		}
		
		/*
		* RememberMe
		*/
		if (isset($_POST['rememberme']) && !empty($_POST['rememberme'])) {
			$this->accountData['rememberMe'] = true;
		} else if (isset($_POST['rememberme']) && empty($_POST['rememberme'])) {
			$this->accountData['rememberMe'] = false;
		}
		
		/*
		* 2)  VALIDATION
		*/
		
		if (Tools::mtrue($this->validUsername, $this->validPassword)) {
			
			/*
			* Login the Account
			*/
			if ($this->core->notifyMediator("AccountManager", "loginAccount", 0, $this->accountData)) {
				
				/*
				* When successful, redirect to home
				*/
				Tools::redirect($this->core->notifyMediator("RouterManager", "getRouteLink", 'HomePage'));
			
			}
			
			/*
			* If anything failed, invalidate all
			*/
			$this->validUsername = false;
			$this->validPassword = false;
			
		}
			
		/*
		* 3) TEMPLATE
		*/
		
		$slotTokens = array();
		$slotTokens['size'] = 28;
		
		$this->templateTokens['valueUsername'] 		= $this->accountData['name'];
		$this->templateTokens['valuePassword'] 		= $this->accountData['password'];
		$this->templateTokens['valueRememberMe'] 	= $this->accountData['rememberMe'];
		
		$this->templateTokens['slotUsername'] 		= '';
		$this->templateTokens['slotPassword']		= '';
		
		/*
		* Username
		*/
		if ($this->validUsername)
		{
			$this->templateTokens['slotUsername'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['name'])) {
			$this->templateTokens['slotUsername'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		/*
		* Password
		*/
		if ($this->validPassword)
		{
			$this->templateTokens['slotPassword'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['password'])) {
			$this->templateTokens['slotPassword'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
		
		/*
		* 4) MESSAGE
		*/
		
		// Message
		$this->templateTokens['message'] = '';
		#$this->templateTokens['message'] = $this->core->notifyMediator("LanguageManager", "getLanguage", 'confirmSuccess');
		
	}
		
}