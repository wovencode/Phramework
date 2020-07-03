<?php
namespace phramework;
use phramework;

/**
*
* AccountRegisterPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountRegisterPage extends BasePage
{
	
	/*
	* Class Variables
	*/
	protected array $accountData = array();
	
	protected bool $validUsername 	= false;
	protected bool $validPassword 	= false;
	protected bool $validEmail 		= false;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccountRegisterPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
		
		$this->validUsername = false;
		$this->validPassword = false;
		$this->validEmail = false;
		
		/*
		* 1) DATA
		*/
		
		/*
		* Username
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
		* Email
		*/
		if (isset($_POST['email'])) {
			$this->accountData['email'] = $_POST['email'];
			$this->validEmail = Tools::validateEmail($_POST['email']);
		}
		
		/*
		* Language
		*/
		if (isset($_POST['language'])) {
			$this->accountData['language'] = $_POST['language'];
			$this->core->notifyMediator("LanguageManager", "setLanguage", $_POST['language']);
		}	
		
		/*
		* 2) VALIDATE
		*/
			
		if (Tools::mtrue($this->validUsername, $this->validPassword, $this->validEmail)) {
		
			/*
			* Register the Account
			*/
			if ($this->core->notifyMediator("AccountManager", "registerAccount", 0, $this->accountData)) {
				
				/*
				* Login the Account
				*/
				if ($this->core->notifyMediator("AccountManager", "loginAccount", 0, $this->accountData)) {
				
					/*
					* When successful, redirect to home
					*/
					Tools::redirect($this->core->notifyMediator("RouterManager", "getRouteLink", 'HomePage'));
				
				}
				
			}
			
			/*
			* If anything failed, invalidate all
			*/
			$this->validUsername = false;
			$this->validPassword = false;
			$this->validEmail = false;
			
		}
		
		/*
		* 3) TEMPLATE
		*/
		
		$slotTokens = array();
		$slotTokens['size'] = 28;
		
		$this->templateTokens['valueUsername'] 	= isset($this->accountData['name']) ? $this->accountData['name'] : '';
		$this->templateTokens['valuePassword'] 	= isset($this->accountData['password']) ? $this->accountData['password'] : '';
		$this->templateTokens['valueEmail'] 	= isset($this->accountData['email']) ? $this->accountData['email'] : '';
		
		$this->templateTokens['slotUsername'] 		= '';
		$this->templateTokens['slotPassword']		= '';
		$this->templateTokens['slotEmail'] 			= '';
		
		// Username
		if ($this->validUsername)
		{
			$this->templateTokens['slotUsername'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['name'])) {
			$this->templateTokens['slotUsername'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		// Password
		if ($this->validPassword)
		{
			$this->templateTokens['slotPassword'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['password'])) {
			$this->templateTokens['slotPassword'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		// Email
		if ($this->validEmail)
		{
			$this->templateTokens['slotEmail'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['email'])) {
			$this->templateTokens['slotEmail'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		// Message
		$this->templateTokens['message'] = '';
		#$this->templateTokens['message'] = $this->core->notifyMediator("LanguageManager", "getLanguage", 'confirmSuccess');
		
	}
	
}