<?php
namespace phramework;
use phramework;

/**
*
* BaseSystemTask
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseSystemTask extends BaseObject
{
	
	/**
	*
	* Constructor (Overriden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		parent::__construct($core);
	}
	
	/**
	*
	* canExecute
	*
	* Checks if it is time to execute the task again
	*
	* @param timestamp $timeStamp
	* @return bool
	*
	*/
	public function canExecute($timeStamp) : bool
	{
	
		/*
		* 1) Check the probability
		*/
		if ($this->active == true && Tools::ProbabilityCheck($this->data['chance'])) {
	
			/*
			* 2)  Check if enough time passed
			*/
			if (Tools::checkDuration($timeStamp, $this->data['interval'])) {
			
				$this->executeTask();
				Tools::log("[TaskManager] Executing system task: " . get_class($this));
				return true;
			
			}
			
		}
		
		return false;
	
	}
	
	/**
	*
	* executeTask (Abstract)
	*
	* Called when the task is executed
	*
	*/
	protected abstract function executeTask();
	
}