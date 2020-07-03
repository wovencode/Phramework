<?php
namespace phramework;
use phramework;

/**
*
* AccountListPage
*
* @author Fhiz
* @version 1.0
*
*/
class AccountListPage extends BasePage
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
		$this->configName = "AccountListPageConfig";
		
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
		* Prepare Data
		*/
		
		$count = $this->core->notifyMediator("DatabaseManager", "executeScalar", 1, 'SELECT COUNT(*) FROM `account`');
		$nowPage = 0;
		$endPage = ceil($count/$this->config->maxAccounts);
		
		/*
		* Pagination by POST
		*/
		
		if (isset($_GET['c']))
		{
			$nowPage = Tools::clamp($_GET['c'], 0, $endPage);
		}
		
		$rowOffset = $nowPage * $this->config->maxAccounts;
		
		$this->templateTokens['link'] = $this->core->notifyMediator("RouterManager", "getRouteLink", "AccountListPage", false);
		
		/*
		* Exclude own Account
		*/
		$uid = '';
		
		if (!$this->config->includeOwnAccount)
			$uid = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", 0, "uniqueId");
		
		/*
		* Pagination Data
		*/
		$data['now'] 				= $nowPage+1;
		$data['total'] 				= $endPage;
		$data['disabledLeft']		= ($nowPage <= 0) ? 'disabled' : '';
		$data['disabledRight'] 		= ($nowPage+1 >= $endPage) ? 'disabled' : '';
		$data['pageNumberLeft'] 	= $nowPage-1;
		$data['pageNumberRight'] 	= $nowPage+1;
		
		/*
		* Note: a strange PDO bug does not allow us to set both LIMIT and OFFSET or ?, ?
		* Therefore shorthand writing was used with both parameters added manually to the query
		*/
		$results = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE `uniqueId`<>? AND `deleted`=0 AND `banned`=0 ORDER BY `name` ASC LIMIT ".$rowOffset.", ".$this->config->maxAccounts, $uid);

		if (!is_null($results) && Tools::countArrayDimensions($results) > 1)
			$this->notifyPagelet('AccountListTablePagelet', 'buildTable', $results, $data);
		
	}
	
}