<?php
namespace phramework;
use phramework;

/**
*
* InstallManager
*
* @author Fhiz
* @version 1.0
*
*/
final class InstallManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "InstallManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
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
	
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
	*
	* executeInstall
	*
	* @return bool
	*
	*/
	public function executeInstall() : bool
	{
		return $this->core->notifyMediator("DatabaseManager", 0, "executeInstall");
	}
		
}