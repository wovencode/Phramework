<?php
namespace phramework;
use phramework;

/**
*
* BaseObject
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseObject
{
	
	protected ?CoreManager $core 	= NULL;
	
	protected array $temporary_data = array();
	protected array $database_data 	= array();
	
	protected bool $changed 		= false;
	protected bool $active			= true;
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->core = $core;
	}
	
	/**
	*
	* isValid
	*
	*
	* @return bool
	*
	*/
	public function isValid() : bool
	{
		return ($this->active == true && !is_null($this->database_data) && !empty($this->database_data));
	}
	
	/**
	*
	* hasChanged
	*
	* @return bool
	*
	*/
	public function hasChanged() : bool
	{
		return $this->changed;
	}
	
	/**
	*
	* changed
	*
	* @return void
	*
	*/
	public function changed()
	{
		$this->changed = true;
	}
	
	/**
	*
	* parseTemporaryData
	*
	* 
	*
	*/
	public function parseTemporaryData(array $data) : bool
	{
		if (!is_null($data) && !empty($data))
		{
			$this->temporary_data = array();
			$this->temporary_data = $data;
			return true;
		}
		return false;
	}
	
	/**
	*
	* parseDatabaseData
	*
	*
	* @return bool
	*
	*/
	public function parseDatabaseData(array $data, bool $changed=false) : bool
	{
		
		if (!is_null($data) && !empty($data))
		{
		
			/*
			* Parse all data, also switches changed flag
			*/
			$this->database_data = array();
			$this->database_data = $data;
			
			$this->changed = $changed;
			
			return true;
		}
		
		$this->database_data = NULL;
		return false;
		
	}
	
	/**
	*
	* getTemporaryData
	*
	*
	* @return array|mixed
	*
	*/
	public function getTemporaryData(string $key='')
	{
		
		/*
		* Retrieve a single key/value pair
		*/
		if (!empty($key) && isset($this->temporary_data[$key]))
			return $this->temporary_data[$key];
		
		return $this->temporary_data;
		
	}
	
	/**
	*
	* getDatabaseData
	*
	*
	* @return array|mixed
	*
	*/
	public function getDatabaseData(string $key='', bool $changed=true)
	{
		
		/*
		* Retrieve a single key/value pair
		*/
		if (!empty($key) && isset($this->database_data[$key]))
			return $this->database_data[$key];
		
		/*
		* Retrieve all data, also switches changed flag
		*/
		$this->changed = $changed;
		
		return $this->database_data;
		
	}
	
	/**
	*
	* setTemporaryData
	*
	*
	* @return bool
	*
	*/
	public function setTemporaryData(string $key, $value) : bool
	{
		$this->temporary_data[$key] = $value;
		return true;
	}
	
	/**
	*
	* setDatabaseData
	*
	*
	* @return bool
	*
	*/
	public function setDatabaseData(string $key, $value, bool $changed=true) : bool
	{
		$this->database_data[$key] = $value;
		$this->changed = $changed;
		return true;		
	}
	
}