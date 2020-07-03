<?php
namespace phramework;
use phramework;

/**
*
* SettingsScreenConfig
*
* @author Fhiz
* @version 1.0
*
*/
class SettingsScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	public $buttons = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "SettingsScreenPagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['LangSettings'] 		= 'settings';
		$this->languageNames['LangLanguage'] 		= 'language';
		$this->languageNames['LangAvatar'] 			= 'avatar';
		$this->languageNames['LangSubmit'] 			= 'submit';
		$this->languageNames['LangSettingsInfo'] 	= 'infoSettings';
		
		/*
		*
		* Parameter
		*
		* @param string tokenName		(the token inside the template to be replaced)
		* @param string templateName	(the template file used)
		* @param string labelName		(The language token used, replaced with the current language)
		* @param string linkTarget		(The name of a page as routing target, must be present in router config)
		* @param string linkClass 		(Should be 'link external' , is editable)
		* @param string iconName 		(The actual icon in the Public/Media/Icons folder, include suffix and a optional subfolder)
		* @param string iconClass 		(used to define icon size, is editable)
		* @param bool isLoggedIn 		(Available while logged in?)
		* @param bool isLoggedOut		(Available while logged out?)
		* @param bool isConfirmed		()
		* @param bool accessUnconfirmed		()
		* @param int minAdminLevel		()
		* @param bool isRiskyAction
		*
		*/
		
		$this->data[] = new NavigationSlot(array('tokenName' => 'buttonConfirmAccount',		'templateName' => 'F7Button.slot', 'slotPrefabName' => 'F7Icon.slot', 	'labelName' => 'confirmAccount', 	'linkTarget' => 'AccountConfirmPage', 			'linkClass' => 'link external', 'iconName' => 'checkmark_alt_circle_fill', 	'iconClass' => 'ph-icon-size-xs', 'color' => 'green', 'isLoggedIn' => true, 	'isLoggedOut' => false, 	'isConfirmed' => false, 	'accessUnconfirmed' => true, 	'isRiskyAction' => true));
		$this->data[] = new NavigationSlot(array('tokenName' => 'buttonChangeEmail',		'templateName' => 'F7Button.slot', 'slotPrefabName' => 'F7Icon.slot',	'labelName' => 'changeEmail', 		'linkTarget' => 'AccountChangeEmailPage', 		'linkClass' => 'link external', 'iconName' => 'envelope_circle_fill', 		'iconClass' => 'ph-icon-size-xs', 'color' => 'green', 'isLoggedIn' => true, 	'isLoggedOut' => false,		'isConfirmed' => true, 		'accessUnconfirmed' => false, 	'isRiskyAction' => true));
		$this->data[] = new NavigationSlot(array('tokenName' => 'buttonChangePassword',		'templateName' => 'F7Button.slot', 'slotPrefabName' => 'F7Icon.slot',	'labelName' => 'changePassword', 	'linkTarget' => 'AccountChangePasswordPage', 	'linkClass' => 'link external', 'iconName' => 'lock_circle_fill', 			'iconClass' => 'ph-icon-size-xs', 'color' => 'green', 'isLoggedIn' => true, 	'isLoggedOut' => false,		'isConfirmed' => true, 		'accessUnconfirmed' => false, 	'isRiskyAction' => true));
		$this->data[] = new NavigationSlot(array('tokenName' => 'buttonDeleteAccount',		'templateName' => 'F7Button.slot', 'slotPrefabName' => 'F7Icon.slot',	'labelName' => 'deleteAccount', 	'linkTarget' => 'AccountDeletePage', 			'linkClass' => 'link external', 'iconName' => 'delete_right_fill', 			'iconClass' => 'ph-icon-size-xs', 'color' => 'green', 'isLoggedIn' => true, 	'isLoggedOut' => false,		'isConfirmed' => true, 		'accessUnconfirmed' => false, 	'isRiskyAction' => true));
		
		parent::__construct();
	}
	
}