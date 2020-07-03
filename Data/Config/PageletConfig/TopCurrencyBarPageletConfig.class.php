<?php
namespace phramework;
use phramework;

/**
*
* TopCurrencyBarConfig
*
* The config file for the Navbar as common in Android and iOS apps, its always located
* at the bottom of the screen and uses the theme's global background color. The Navbar
* contains links that are represented by a small icon as well as a text label.
*
* Learn more about the Framework7 component here:
* https://framework7.io/docs/toolbar-tabbar.html
*
* @author Fhiz
* @version 1.0
*
*/
class TopCurrencyBarPageletConfig extends BasePageletConfig
{
	
	/*
	* Class Variables
	*/
	
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		/*
		* Pagelet Template (Required)
		*/
		$this->templateName = "TopCurrencyBarPagelet";
		
		/*
		*
		* Parameter
		*
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
		*
		*/
		
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'index', 			'linkTarget' => 'IndexPage', 					'linkClass' => 'link external', 'iconName' => 'Default/magic-gate.png', 	'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => false, 	'isLoggedOut' => true));
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'home', 				'linkTarget' => 'HomePage', 					'linkClass' => 'link external', 'iconName' => 'Default/house.png', 			'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'register', 			'linkTarget' => 'AccountRegisterPage', 			'linkClass' => 'link external', 'iconName' => 'Default/key-card.png', 		'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => false, 	'isLoggedOut' => true));
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'login', 			'linkTarget' => 'AccountLoginPage', 			'linkClass' => 'link external', 'iconName' => 'Default/key.png', 			'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => false, 	'isLoggedOut' => true));
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'logout', 			'linkTarget' => 'AccountLogoutPage', 			'linkClass' => 'link external', 'iconName' => 'Default/door.png', 			'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		#$this->data[] = new NavigationSlot(array('templateName' => 'BottomNavbar.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'forgotPassword', 	'linkTarget' => 'AccountResetPasswordPage', 	'linkClass' => 'link external', 'iconName' => 'Default/circle.png', 		'iconClass' => 'ph-icon-size-xs', 'isLoggedIn' => false, 	'isLoggedOut' => true));
				
		parent::__construct(); // Required!
		
	}
	
}