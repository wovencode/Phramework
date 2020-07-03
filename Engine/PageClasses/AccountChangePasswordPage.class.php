<?php
namespace phramework;
use phramework;

/**
*
* AccountChangePasswordPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangePasswordPage extends BasePage
{
	
	/*
	* Class Variables
	*/
	protected array $accountData = array();
	
	protected bool $validPassword 	= false;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		$this->accountData = array();
		$this->accountData['password'] = '';
		
		/*
		* Config File (Required)
		*/
		$this->configName = "AccountChangePasswordPageConfig";
		
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
		* Post Password
		*/
		if (isset($_POST['passwordNew'])) {
			$this->accountData['password'] = $_POST['passwordNew'];
			$this->validPassword = $this->core->notifyMediator("AccountManager", "validatePassword", $this->accountData['password']);
		}
		
		/*
		* VALIDATION
		*/
		
		if (isset($_GET['c'])) {
			
			/*
			* Try to change the password
			*/
			if ($this->core->notifyMediator("AccountManager", "changeAccountPassword", 0, $_GET['c'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changePasswordSuccess', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changePasswordFailure', 'failureFooter', $this->config->slotNameFailure);
			}
			
		} else if ($this->validPassword == true) {
			
			/*
			* Generate and send a new reset code
			*/
			if ($this->core->notifyMediator("AccountManager", "requestChangeAccountPassword", 0, $this->accountData['password'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changePasswordRequest', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changePasswordFailure', '', $this->config->slotNameFailure);
			}
			
		} else {
			
			$this->notifyPagelet('ModalWindowPagelet', 'removePopup');
			
			/*
			* If anything failed, invalidate all
			*/
			$this->validPassword = false;
		}
				
		/*
		* TEMPLATE
		*/
		
		$slotTokens = array();
		$slotTokens['size'] = 28;
		
		$this->templateTokens['valuePasswordNew'] 	= '';
		
		$this->templateTokens['slotEmail'] 		= '';
		
		/*
		* PASSWORD SLOT
		*/
		$this->templateTokens['slotPasswordCurrent'] 	= '';
		$this->templateTokens['slotPasswordNew'] 		= '';
		
		if ($this->validPassword == true) {
			$this->templateTokens['slotPasswordNew'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['password'])) {
			$this->templateTokens['slotPasswordNew'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		/*
		* MESSAGE
		*/
		
		$this->templateTokens['message'] = '';
		
	}
	
}