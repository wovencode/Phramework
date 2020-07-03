<?php
namespace phramework;
use phramework;

/**
*
* TaskRemindUnconfirmedAccounts
*
* @author Fhiz
* @version 1.0
*
*/
class TaskRemindUnconfirmedAccounts extends BaseSystemTask
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
		$this->data['interval'] = 86400;
		
		/*
		* string duration
		*
		* x MINUTE
		* x DAY
		* x WEEK
		* x MONTH
		*
		*/
		$this->data['duration'] = '1 DAY';
		
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

		$results = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE `confirmed`=0 AND `banned`=0 AND `deleted`=0 AND `created` <= DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL ".$this->data['duration'].")");
		
		if (is_null($results))
			return;
		
		$counter = 0;
		
		foreach ($results as $result)
		{
			$this->core->notifyMediator("MailManager", "sendRegistrationConfirmation", $result['email'], $result['securityToken']);
			$counter++;
		}
		
		Tools::log("[TaskManager] Reminded <".$counter."> unconfirmed accounts.");
		
	}
	
}