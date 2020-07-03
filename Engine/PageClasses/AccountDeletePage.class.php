<?php
namespace phramework;
use phramework;

/**
*
* AccountDeletePage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountDeletePage extends BasePage
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
		$this->configName = "AccountDeletePageConfig";
		
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
			* Try to delete the account
			*/
			if ($this->core->notifyMediator("AccountManager", "deleteAccount", 0, $_GET['c'])) {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','deleteSuccess', '', $this->config->slotNameSuccess);
			} else {
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','deleteFailure', '', $this->config->slotNameFailure);
			}
			
		} else {
		
			/*
			* Generate and send a new deletion code
			*/
			if ($this->core->notifyMediator("AccountManager", "requestDeleteAccount", 0)) {
				
				/*
				* Show Popup
				*/
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','deleteRequest', '', $this->config->slotNameSuccess);
			
			}
			
		}
		
	}
		
}