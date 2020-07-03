<?php
namespace phramework;
use phramework;

/**
*
* AccountListTablePagelet
*
* @author Fhiz
* @version 1.0
*
*/
class AccountListTablePagelet extends DataTablePagelet
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "AccountListTablePageletConfig";
		parent::__construct($core);
	}
		
	/**
	*
	* buildTable
	*
	*/
	public function buildTable(array $entries, array $data)
	{
		
		/*
		* Pagination
		*/
		$this->templateTokens['now'] 				= $data['now'];
		$this->templateTokens['total'] 				= $data['total'];
		$this->templateTokens['disabledLeft'] 		= $data['disabledLeft'];
		$this->templateTokens['disabledRight'] 		= $data['disabledRight'];
		$this->templateTokens['pageNumberLeft'] 	= $data['pageNumberLeft'];
		$this->templateTokens['pageNumberRight'] 	= $data['pageNumberRight'];
		
		/*
		* Entries
		*/
				
		foreach ($entries as $row)
		{
		
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
			* @param bool accessUnconfirmed	()
			* @param int minAdminLevel		()
			*
			*/
		
			$this->data[] = new AccountListSlot(array('templateName' => 'AccountTableRow.slot', 'slotPrefabName' => 'ImageIcon.slot',	'uniqueId' => $row['uniqueId'], 'labelName' => $row['name'], 	'linkTarget' => 'AccountInspectPage', 	'linkClass' => 'link external', 'iconName' => $row['avatar'], 	'iconClass' => 'ph-icon-size-s', 'isLoggedIn' => true, 	'isLoggedOut' => false));
		
		}
		
	}
	
}