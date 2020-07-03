<?php
namespace phramework;
use phramework;

/**
*
* Colleague
*
* The Colleague class acts as a receiver for events messages sent from the Mediator class.
* Each Colleage only reacts to the events defined in its configuration file and
* triggers a function tied to that event.
*
* @author Fhiz
* @version 1.0
*
*/
final class Colleague
{
   
  	/*
	* Class Variables
	*/
	protected ?CoreManager $core = NULL;
	protected ?object $parent = NULL;
  	protected array $data = array();
  	
	/**
	*
	* Constructor
	*
	*/
    public function __construct(CoreManager&$core=NULL, object&$parentClass=NULL)
    {
    	if (!is_null($core))
    		$this->core = $core;
    	
    	if (!is_null($parentClass))
    		$this->parent = $parentClass;
    	
    }
    
	/**
    * 
    * notify
    * 
    * Triggers the function tied to the event message, including any amount of parameters.
    *
    * @param object $senderName
	* @param string $functionName
	* @return mixed
	*
    */
	public function notify(string $senderName, string $functionName, ...$params) /* : mixed */
	{
		return call_user_func(array($this->parent, $functionName), ...$params);		
	}
	
	/**
    * 
    * canNotify
    *
    * Checks if the Colleague's parent has a function of the given name.
	*
	* @param string $event
	* @return bool
	*
    */
	public function canNotify(string $functionName) : bool
	{
		return method_exists($this->parent, $functionName);		
	}
	
}