<?php
namespace phramework;
use phramework;

/**
*
* AccountChangeEmailPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountChangeEmailPage extends BasePage
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
		$this->configName = "AccountChangeEmailPageConfig";
		
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
		if (isset($_POST['emailNew'])) {
			$this->accountData['email'] = $_POST['emailNew'];
			$this->validEmail = $this->core->notifyMediator("AccountManager", "validateEmail", $this->accountData['email']);
		}
		
		/*
		* VALIDATION
		*/
		
		if (isset($_GET['c'])) {
			
			/*
			* Try to change the email
			*/
			if ($this->core->notifyMediator("AccountManager", "changeAccountEmail", 0, $_GET['c'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changeEmailSuccess', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changeEmailFailure', 'failureFooter', $this->config->slotNameFailure);
			}
			
		} else if ($this->validEmail == true) {
			
			/*
			* Generate and send a new reset code
			*/
			if ($this->core->notifyMediator("AccountManager", "requestChangeAccountEmail", 0, $this->accountData['email'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changeEmailRequest', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','changeEmailFailure', '', $this->config->slotNameFailure);
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
		
		$this->templateTokens['valueEmailNew'] 	= '';
		
		/*
		* EMAIL SLOT
		*/
		$this->templateTokens['slotEmailCurrent'] 	= '';
		$this->templateTokens['slotEmailNew'] 		= '';
		
		if ($this->validEmail == true) {
			$this->templateTokens['slotEmailNew'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameSuccess, $slotTokens, $this->config::CONST_SLOT);
		} else if (!empty($this->accountData['email'])) {
			$this->templateTokens['slotEmailNew'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->config->slotNameFailure, $slotTokens, $this->config::CONST_SLOT);
		}
				
		/*
		* MESSAGE
		*/
		
		$this->templateTokens['message'] = '';
		
	}
	
}