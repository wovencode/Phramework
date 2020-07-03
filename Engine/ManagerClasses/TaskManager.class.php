<?php
namespace phramework;
use phramework;

/**
*
* TaskManager
*
* @author Fhiz
* @version 1.0
*
*/
final class TaskManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected $tasks = array();
	protected $results = NULL;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "TaskManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Override)
	*
	*/
	protected function initialize()
	{
		
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	*/
	public function initializeLate() : void
	{
		$this->runScheduledTasks();
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
	*
	* runScheduledTasks
	*
	*/
	private function runScheduledTasks()
	{
		
		/*
		* 1) Check if installation is complete first (TaskManager wont work without)
		*/
		if (!$this->core->notifyMediator("DatabaseManager", "tableExists", 0, 'system_task'))
			return;
		
		/*
		* 2) Fetch last execution times from database
		*/
		$this->results = $this->core->notifyMediator("DatabaseManager", "executeReader", 0, 'SELECT * FROM `system_task`');
		
		/*
		* 3) 
		*/
		foreach ($this->config::CONST_SYSTEM_TASKS as $taskName)
		{
		
			$className = __NAMESPACE__ . "\\" . $taskName;
			$this->tasks[$taskName] = new $className($this->core);
			
			$timeStamp = $this->getTaskTimeStamp($taskName);
			
			/*
			* Check and execute the task
			*/
			if ($this->tasks[$taskName]->canExecute($timeStamp))
			{
				
				
				if (empty($timeStamp)) {
					
					/*
					* Insert the task in the database
					*/
					
					$data = array();
					
					$data['name'] 	= $taskName;
					$data['count'] 	= 1;
					$data['tstamp'] = Tools::now();
					
					$this->core->notifyMediator("DatabaseManager", "executeArray", 0, "INSERT INTO", "system_task", $data);
				
				} else {
				
					/*
					* Update the task in the database
					*/
					$this->core->notifyMediator("DatabaseManager", "executeQuery", 0, "UPDATE `system_task` SET `count` = `count` + 1, `tstamp` = CURRENT_TIMESTAMP() WHERE `name` = '".$taskName."' LIMIT 1");
				
				}
				
			}
		
		}
	
	}
		
	/**
	*
	* getTaskTimeStamp
	*
	* @param string $taskName
	* @return string
	*
	*/
	protected function getTaskTimeStamp(string $taskName) : string
	{
	
		if (is_null($this->results))
			return '';
			
		foreach ($this->results as $result) {
			if ($result['name'] == $taskName) {
				return $result['tstamp'];
			}
		}
		
		return '';
	
	}
		
}