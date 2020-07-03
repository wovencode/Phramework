<?php
namespace phramework;
use phramework;

/**
*
* AccountSettingsPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountSettingsPage extends BasePage
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
		$this->configName = "AccountSettingsPageConfig";
		
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
		* Update Avatar
		*/
		if (isset($_FILES['avatar']) && !empty($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name']) )
		{
		
			$fileName = $this->core->notifyMediator('InputManager', 'validateUpload', 'avatar');
			
			if (!empty($fileName)) {
			
				$this->core->notifyMediator('AccountManager', 'setAccountDatabaseData', 0, 'avatar', $fileName);
				
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','avatarSuccess', '', $this->config->slotNameSuccess);
				
			} else {
			
				$this->notifyPagelet('ModalWindowPagelet', 'buildPopup','avatarFailure', 'avatarFooter', $this->config->slotNameFailure);
				
			}
			
		} else {
			$this->notifyPagelet('ModalWindowPagelet', 'removePopup');
		}
		
		/*
		* Update Language
		*/
		if (isset($_POST['language'])) {
		
			/*
			* Update Account
			*/
			if ($this->core->notifyMediator("LanguageManager", "hasLanguage", $_POST['language'])) {
				$this->core->notifyMediator('AccountManager', 'setAccountDatabaseData', 0, 'language', $_POST['language']);
			}
			
		}	
		
	}
		
}