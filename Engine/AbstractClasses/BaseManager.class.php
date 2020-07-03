<?php
namespace phramework;
use phramework;

/**
*
* BaseManager (Abstract)
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseManager
{
	
	/*
	* Class Variables
	*/
	protected ?CoreManager $core = NULL;
	
	protected string $configName = "";
	protected $config = NULL;										// Holds the actual Config Class (Untyped)
	
	protected string $colleagueName = "Colleague";
	protected $colleague;											// Colleague Class (Untyped)

	protected ?EventDispatcher $eventDispatcher = NULL;	
	protected $eventResolver;										// Event Resolver (Untyped)
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core=NULL)
	{
		
		self::initializeCore($core);
		self::initializeConfiguration();
		self::initializeColleague();
	
		static::initializeEvents();
	
		/*
		* This is the actual constructor that derived classes use
		*/
		static::initialize();
	
	}
	
	/*
	*
	* Destructor
	*
	*/
	public function __destruct()
	{
		
	}
	
	/**
	*
	* initializeCore
	*
	*/
	protected function initializeCore(CoreManager&$core=NULL)
	{
		if (!is_null($core))
			$this->core = $core;
	}
	
	/**
	*
	* initializeConfiguration
	*
	*/
	protected function initializeConfiguration()
	{
		if (!empty($this->configName))
		{
			$className = __NAMESPACE__ . "\\" . $this->configName;
			$this->config = new $className();
		}
	}
	
	/**
	*
	* initializeColleague
	*
	*/
	protected function initializeColleague()
	{
		if (!empty($this->colleagueName))
		{
			$className = __NAMESPACE__ . "\\" . $this->colleagueName;
			$this->colleague = new $className($this->core, $this);
		}
	}
	
	/**
	*
	* initializeEvents
	*
	* Instantiate the Event Dispatcher/Resolver and add a reference to it
	*
	*/
	protected function initializeEvents()
	{
	
		/*
		* Initialize Event Resolver
		*/
		if (!empty($this->config->eventResolver)) {
			$className = __NAMESPACE__ . "\\" . $this->config->eventResolver;
			$this->eventResolver = new $className($this->core, $this);
		}
		
		/*
		* Initialize Event Dispatcher
		*/
		$this->eventDispatcher = new EventDispatcher($this->core, $this->eventResolver);
		
	}
	
	/**
	*
	* Initialize (Abstract)
	*
	* Called during Constructor
	*
	*/
	protected abstract function initialize();
	
	/**
	*
	* initializeLate (Abstract)
	*
	* Called from the CoreManager after all managers have been constructed
	*
	*/
	public abstract function initializeLate();
	
	/*
	* ====================================================================================
	*                                MEDIATOR / COLLEAGUE
	* ====================================================================================
	*/
	
	/**
	*
	* notifyMediator (Wrapper)
	*
	*
	* @param object $managerName
	* @param string $functionName
	* @return mixed
	*
	*/
	public function notifyMediator(string $managerName, string $functionName, ...$params)
	{
		return $this->mediator->notify($managerName, $functionName, ...$params);
	}
	
	/**
	*
	* notifyColleague (Wrapper)
	*
	*
	* @param object $managerName
	* @param string $functionName
	* @return mixed
	*
	*/
	public function notifyColleague(string $managerName, string $functionName, ...$params)
	{
		return $this->colleague->notify($managerName, $functionName, ...$params);
	}
	
	/**
	*
	* canNotifyColleague (Wrapper)
	*
	* @param string $functionName
	* @return bool
	*
	*/
	public function canNotifyColleague(string $functionName) : bool
	{
		if (!is_null($this->colleague))
			return $this->colleague->canNotify($functionName);	
		else
			return false;
	}
	
	/*
	* ====================================================================================
	*                                EVENT DISPATCHER
	* ====================================================================================
	*/
	
	/**
	*
	* dispatchEvent (Wrapper)
	*
	* @param mixed $name
    * @param mixed $arguments
    * @return mixed
	*
	*/
	public function dispatchEvent($name, $arguments=NULL)
	{
		if (!is_null($this->eventDispatcher))
			return $this->eventDispatcher->doDispatch($name, $arguments);	
		else
			return false;
	}
	
	
}