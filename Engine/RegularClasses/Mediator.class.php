<?php
namespace phramework;
use phramework;

/**
*
* Mediator
*
* @author Fhiz
* @version 1.0
*
*/
final class Mediator implements MediatorInterface
{
	
	private ?CoreManager $core = NULL;
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->core = $core;		
	}
	
	/*
	*
	* notify
	*
	* @param object $sender
	* @param string $event
	*
	* @return mixed
	*
	*/
	public function notify(string $receiverName, string $functionName, ...$params)
	{
		
		/*
		* lazy load the manager or return a existing instance
		*/
		$manager = $this->core->loadManager($receiverName);
		
		if (!is_null($manager))
		{
			if ($manager->canNotifyColleague($functionName))
				return $manager->notifyColleague($receiverName, $functionName, ...$params);
		}
		
		return NULL;
		
	}
	
}