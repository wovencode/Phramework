<?php
namespace phramework;
use phramework;

/**
*
* TaskPruneBannedAccounts
*
* @author Fhiz
* @version 1.0
*
*/
class TaskPruneBannedAccounts extends BaseSystemTask
{
	
	/**
	*
	* Constructor (Overriden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		/*
		* Check chance in percentage
		*/
		$this->data['chance'] 	= 100;
		
		/*
		* Check interval in seconds
		*
		* 60 		= 1 minute
		* 3600 		= 1 hour
		* 21600		= 6 hours
		* 43200 	= 12 hours
		* 86400 	= 1 day (24 hours)
		* 259200	= 3 days
		* 604800	= 7 days
		* 1209600	= 14 days
		* 2592000	= 30 days (1 month)
		* 5184000	= 60 days (2 months)
		* 7776000	= 90 days (3 months)
		* 15552000	= 180 days (6 months) 
		*
		*/
		$this->data['interval'] = 3600;
		
		/*
		* string duration
		*
		* x MINUTE
		* x DAY
		* x WEEK
		* x MONTH
		*
		*/
		$this->data['duration'] = '30 DAY';
		
		parent::__construct($core); // Required!
		
	}
	
	/**
	*
	* executeTask (Overridden)
	*
	* Called when the task is executed
	*
	*/
	protected function executeTask()
	{

		$this->core->notifyMediator("DatabaseManager", "executeQuery", 1, "UPDATE `account` SET `deleted`=1 WHERE `banned`=1 AND `lastonline` <= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL ".$this->data['duration'].")");
		$counter = $this->core->notifyMediator("DatabaseManager", "getAffectedRows", 1);
		Tools::log("[TaskManager] Pruned <".$counter."> banned accounts.");
		
	}
	
}