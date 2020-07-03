<?php
namespace phramework;
use phramework;

/**
*
* EventDispatcher
*
* @author Fhiz
* @version 1.0
*
*/
final class EventDispatcher
{

	protected ?CoreManager $core 	= NULL;
    protected $config = NULL;										// Holds the actual Config Class (Untyped)
    
    public static array $events;
    public static string $current_event;
    public static array $happened_events;
	public static array $parentClasses;
	
	/**
	*
	* Constructor
	*
	*/
    public function __construct(CoreManager&$core=NULL, &$parentClass=NULL)
    {
    
    	if (!is_null($core))
    		$this->core = $core;
    	
    	$this->config = new EventDispatcherConfig();
    	    	
    	if (empty(self::$events))
    		self::$events = array();
    	
    	if (empty(self::$current_event))
    		self::$current_event = '';
    	
    	if (empty(self::$happened_events))
    		self::$happened_events = array();
    	
    	if (empty(self::$parentClasses))
    		self::$parentClasses = array();
    	
    	self::$parentClasses[] = $parentClass;
    	
    	self::setupListeners();
    	
    }
    
	/**
     * setupListeners
     *
     * sets up all listeners (once)
     *
     */
	protected function setupListeners()
	{
	
		foreach ($this->config->events as $key => $functionName)
			self::addListener($key, $functionName);
	
	}
	
    /**
    * addListener
    *
    * Add a new trigger
    *
    * @param mixed $name
    * @param mixed $function
    * @param mixed $priority
    */
    public function addListener($name, $function, $priority = 10)
    {
    	
        // return true if event has already been registered
        if (isset(self::$events[$name][$priority][$function])) {
            return true;
        }
		
        /**
        * Allows us to iterate through multiple event hooks.
        */
        if (is_array($name)) {
            foreach ($name as $name) {
                self::$events[$name][$priority][$function] = array("function" => $function);
            }
        } else {
            self::$events[$name][$priority][$function] = array("function" => $function);
        }
        
        return true;
    }

    /**
    * doDispatch
    *
    * Trigger an event Listener
    *
    * @param mixed $name
    * @param mixed $arguments
    * @return mixed
    */
    public function doDispatch($name, $arguments=NULL)
    {
    	
        if (!isset(self::$events[$name])) {
            return $arguments;
        }
        
        // Set the current running event Listener
        self::$current_event = $name;

        ksort(self::$events[$name]);
        
        foreach (self::$events[$name] as $priority => $actions)
        {
            if (is_array($actions))
            {
                foreach ($actions as $action)
                {
                    
                    foreach (self::$parentClasses as $parentClass)
                    {
                    
						// run Listener and store the value returned by registered functions
						if (method_exists($parentClass, $action['function'])) 
						{
							$return_arguments = call_user_func_array(array($parentClass, $action['function']), array(&$arguments));

							if ($return_arguments)
							{
								$arguments = $return_arguments;
							}
							// Store called Listeners
							self::$happened_events[$name][$priority] = $action['function'];
							
						}
                    
                    }
                    
                }
            }
        }

        // This listener is finished its job
        self::$current_event = '';
        
        return $arguments;
    }
      
    /**
    * removeListener
    *
    * Remove the event Listener from event array
    *
    * @param mixed $name
    * @param mixed $function
    * @param mixed $priority
    */
    public function removeListener($name, $function, $priority = 10) : bool
    {
        unset(self::$events[$name][$priority][$function]);

        if (!isset(self::$events[$name][$priority][$function])) {
            return true;
        }
        
        return false;
    }

    /**
    * nowListener
    *
    * Get the currently running event Listener
    *
    */
    public function nowListener()
    {
        return self::$current_event;
    }

    /**
    * isListening
    *
    * Check if a particular Listener has been called
    *
    * @param mixed $name
    * @param mixed $priority
    */
    public function isListening($name, $priority = 10) : bool
    {
        if (isset(self::$events[$name][$priority])) {
            return true;
        }
        return false;
    }

    /**
    * hasListener
    *
    * @param mixed $name
    */
    public function hasListener($name) : bool
    {
        if (isset(self::$events[$name])) {
            return true;
        }
        return false;
    }

}