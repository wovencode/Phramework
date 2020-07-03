<?php
namespace phramework;
use phramework;

/**
*
* TaskPruneUnusedAvatars
*
* @author Fhiz
* @version 1.0
*
*/
class TaskPruneUnusedAvatars extends BaseSystemTask
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
		
		$count = $this->core->notifyMediator("DatabaseManager", "executeScalar", 1, "SELECT COUNT(*) FROM `account`");
		
		$counter 		= 0;
		$stepSize 		= 100;
		$offset 		= 0;
		$defaultAvatar 	= "none.png";
		
		
		for ($i = 1; $i <= $count; $i+=$stepSize) {
    		
    		$results = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT `avatar` FROM `account` WHERE `avatar`<>? LIMIT ? OFFSET ?", $defaultAvatar, $stepSize, $offset);
    		
    		$results[] = $defaultAvatar;
    		
    		if (count($results) <= 0)
    			continue;
    			
    		$directory = Tools::buildPublicPath($this->core->getConfig()->getUploadCDN('.'), '', array($this->core->getConfig()::CONST_PUBLIC, $this->core->getConfig()::CONST_MEDIA, $this->core->getConfig()::CONST_AVATARS));
    		
    		$directoryIterator = new \RecursiveDirectoryIterator($directory);
			
			foreach (new \RecursiveIteratorIterator($directoryIterator) as $file)
			{
				if (filetype($file) != "dir")
				{
					if (!in_array(basename($file), $results))
					{
						@unlink($file);
						$counter++;
					}
				}
			}
    		
		}
		
		Tools::log("[TaskManager] Pruned <".$counter."> unused avatar image(s).");
		
	}
	
}