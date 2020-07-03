<?php
namespace phramework;
use phramework;

/**
*
* CoreManager
*
* Contains all Manager classes required by the engine. Initializes those managers when
* the core itself is instantiated and adds them to an array that can be accessed by
* the public.
*
* @author Fhiz
* @version 1.0
*
*/
final class CoreManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                      HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected $managers = array();
	public ?Mediator $mediator = NULL;
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct()
	{
		$this->configName 		= "CoreManagerConfig";
		parent::__construct();
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize() : void
	{
		$this->mediator = new Mediator($this);
		$this->buildManagers();
		$this->initializeLate();
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	*/
	public function initializeLate() : void
	{
		foreach ($this->managers as $manager)
			$manager->initializeLate();
	}
	
	/*
	*
	* buildManagers
	*
	*/
	private function buildManagers() : void
	{
		foreach ($this->config::CONST_MANAGERS as $manager)
		{
			$className = __NAMESPACE__ . "\\" . $manager;
			$this->managers[$manager] = new $className($this);
		}
	}
		
	/*
	*
	* loadManager
	*
	* @return object
	*
	*/
	public function loadManager(string $managerName) : object
	{
	
		if (!isset($this->managers[$managerName]))
		{
			$className = __NAMESPACE__ . "\\" . $managerName;
			$this->managers[$managerName] = new $className($this);
		}
		
		return $this->managers[$managerName];
		
	}
	
	/*
	*
	* getConfig
	*
	* @return object
	*
	*/
	public function getConfig() : object
	{
		return $this->config;
	}
	
}