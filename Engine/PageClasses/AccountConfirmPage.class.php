<?php
namespace phramework;
use phramework;

/**
*
* AccountConfirmPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountConfirmPage extends BasePage
{
	
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
		$this->configName = "AccountConfirmPageConfig";
		
		parent::__construct($core);	// Required!
		
	}
	
	/**
	*
	* processPage (Overridden)
	*
	*/
	public function processPage()
	{
	
		if (isset($_GET['c'])) {
			
			/*
			* Try to confirm the account
			*/
			if ($this->core->notifyMediator("AccountManager", "confirmAccount", 0, $_GET['c'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup', 'confirmSuccess', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','confirmFailure', '', $this->config->slotNameFailure);
			}
			
		} else {
		
			/*
			* Generate and send a new Confirmation code
			*/
			$this->core->notifyMediator("AccountManager", "requestConfirmAccount", 0);
			
			/*
			* Show Popup
			*/
			$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','confirmRequest', '', $this->config->slotNameSuccess);
			
		}
		
		$_GET['c'] = null;
		
	}
		
}