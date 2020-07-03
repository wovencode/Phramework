<?php
namespace phramework;
use phramework;

/**
*
* AccountResetPasswordPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountResetPasswordPage extends BasePage
{
	
	/*
	* Class Variables
	*/
	protected array $accountData = array();
	
	protected bool $validEmail 	= false;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->accountData = array();
		$this->accountData['email'] = '';
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccountResetPasswordPageConfig";
		
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
		* DATA
		*/
		
		/*
		* Post Email
		*/
		if (isset($_POST['email'])) {
			$this->accountData['email'] = $_POST['email'];
			$this->validEmail = $this->core->notifyMediator("AccountManager", "validateEmail", $this->accountData['email']);
		}
		
		/*
		* VALIDATION
		*/
		
		if (isset($_GET['c'])) {
			
			/*
			* Try to reset the password
			*/
			if ($this->core->notifyMediator("AccountManager", "resetAccountPassword", $_GET['c'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','resetSuccess', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','resetFailure', '', $this->config->slotNameFailure);
			}
			
		} else if ($this->validEmail == true) {
			
			/*
			* Generate and send a new reset code
			*/
			if ($this->core->notifyMediator("AccountManager", "requestResetAccountPassword", $this->accountData)) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','resetRequest', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','resetFailure', '', $this->config->slotNameFailure);
			}
			
		} else {
			
			$this->notifyPagelet('ModalWindowPagelet', 'removePopup');
			
			/*
			* If anything failed, invalidate all
			*/
			$this->validEmail = false;
		}
		
		/*
		* TEMPLATE
		*/
		
		$slotTokens = array();
		$slotTokens['size'] = 28;
		
		$this->templateTokens['valueEmail'] 	= $this->accountData['email'];
		
		$this->templateTokens['slotEmail'] 		= '';
		
		/*
		* EMAIL SLOT
		*/
		if ($this->validEmail == true) {
			$this->templateTokens['slotEmail'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['email'])) {
			$this->templateTokens['slotEmail'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
		
		/*
		* MESSAGE
		*/
		
		$this->templateTokens['message'] = '';
		#$this->templateTokens['message'] = $this->core->notifyMediator("LanguageManager", "getLanguage", 'confirmSuccess');
		
	}
	
}