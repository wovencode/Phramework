<?php
namespace phramework;
use phramework;

/**
*
* FloatingActionButtonPageletConfig
*
* The config file for the Floating Action Button (FAB) known from Android apps.
* FAB can be placed in 9 different locations on the screen and hovers above other elements.
* It comes with 15 different pre-defined background colors. The button opens/closes a floating
* context menu that contains customizeable links. Those links contain both a small icon as
* well as a text label.
*
* Learn more about the Framework7 FAB here:
* https://framework7.io/docs/floating-action-button.html
*
* @author Fhiz
* @version 1.0
*
*/
class FloatingActionButtonPageletConfig extends BasePageletConfig
{
	
	/*
	* Class Variables
	*/
	
	/*
	* Positions
	*
	* right-bottom
	* center-bottom
	* left-bottom
	* right-center
	* center-center
	* left-center
	* right-top
	* center-top
	* left-top 
	*
	*/
	public string $position = "right-top";
	
	/*
	* Direction in which the buttons are shown
	*
	* top
	* bottom
	* left
	* right
	*
	*/
	public string $buttons_direction = "bottom";
	
	/*
	* Colors
	*
	* color-red
	* color-green
	* color-blue
	* color-pink
	* color-yellow
	* color-orange
	* color-purple
	* color-deeppurple
	* color-lightblue
	* color-teal
	* color-lime
	* color-deeporange
	* color-gray
	* color-white
	* color-black
	*
	* See more information about colors and how to add custom colors here:
	*
	* https://framework7.io/docs/color-themes.html
	*
	*/
	public string $color = "color-red";
	
	public array $data = array();
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct()
	{
		
		/*
		* Pagelet Template (Required)
		*/
		$this->templateName = "FloatingActionButtonPagelet";
		
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
		
		$this->data[] = new NavigationSlot(array('templateName' => 'FloatingActionButton.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'profile', 	'linkTarget' => 'AccountProfilePage', 	'linkClass' => 'link external', 'iconName' => 'Default/portrait.png', 	'iconClass' => 'ph-icon-size-s', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		$this->data[] = new NavigationSlot(array('templateName' => 'FloatingActionButton.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'list', 		'linkTarget' => 'AccountListPage', 		'linkClass' => 'link external', 'iconName' => 'Default/checklist.png', 	'iconClass' => 'ph-icon-size-s', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		$this->data[] = new NavigationSlot(array('templateName' => 'FloatingActionButton.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'settings', 	'linkTarget' => 'AccountSettingsPage', 	'linkClass' => 'link external', 'iconName' => 'Default/gears.png', 		'iconClass' => 'ph-icon-size-s', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		$this->data[] = new NavigationSlot(array('templateName' => 'FloatingActionButton.slot', 'slotPrefabName' => 'ImageIcon.slot',	'labelName' => 'logout', 	'linkTarget' => 'AccountLogoutPage', 	'linkClass' => 'link external', 'iconName' => 'Default/door.png', 		'iconClass' => 'ph-icon-size-s', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		
		parent::__construct(); // Required!
		
	}
	
}