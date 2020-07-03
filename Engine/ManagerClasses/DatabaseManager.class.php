<?php
namespace phramework;
use phramework;
use \PDO;

/**
*
* DatabaseManager
*
* PDO based database abstraction layer that supports connections to multiple databases
*
* @author Fhiz
* @version 1.0
*
*/
final class DatabaseManager extends BaseManager
{

	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	private array $connections	= array();
		
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "DatabaseManagerConfig";
		parent::__construct($core);
	}
	
	/*
	*
	* Destructor (Overridden)
	*
	*/
	public function __destruct()
	{
		
		$queryCount = 0;
		
		foreach ($this->connections as $connection)
		{
			$queryCount += $connection->getQueryCount();
			
			foreach ($connection->getQueries() as $query)
				Tools::log("[DatabaseConnection] ".$query);
		
		}
		
		Tools::log("[DatabaseManager] Executed ".$queryCount." queries.");
		
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize() : void
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
	
	/*							
	*
	* checkConnection
	*
	* Checks if a connection of the stated ID exists
	*
	* @param int $connectionId
	* @return bool
	*
	*/
	private function checkConnection(int $connectionId) : bool
	{
		return (isset($this->connections[$connectionId]) && $this->connections[$connectionId] != NULL);	
	}
	
	/*							
	*
	* establishConnection
	*
	* @param int $connectionId
	* @return bool
	*
	*/
	private function establishConnection(int $connectionId) : bool
	{
		
		if ($this->checkConnection($connectionId))
			return TRUE;
		
		$this->connections[$connectionId] = new DatabaseConnection(
															$this->config::CONST_DATABASES[$connectionId]['driver'], 
															$this->config::CONST_DATABASES[$connectionId]['host'], 
															$this->config::CONST_DATABASES[$connectionId]['name'],
															$this->config::CONST_DATABASES[$connectionId]['charset'] ,
															$this->config::CONST_DATABASES[$connectionId]['user'], 
															$this->config::CONST_DATABASES[$connectionId]['password'],
															$this->config::CONST_DATABASES[$connectionId]['port'] 
															);
															
		return ($this->checkConnection($connectionId));
		
	}
	
	/*
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/*							
	*
	* beginTransaction
	*
	* @param int $connectionId
	* @result void
	*
	*/
	public function beginTransaction(int $connectionId=0) : void
	{
		if ($this->establishConnection($connectionId))
			$this->connections[$connectionId]->beginTransaction();
	}
	
	/*							
	*
	* commitTransaction
	*
	* @param int $connectionId
	* @result void
	*
	*/
	public function commitTransaction(int $connectionId=0) : void
	{
		if ($this->establishConnection($connectionId))
			$this->connections[$connectionId]->commit();
	}
	
	/*							
	*
	* getAffectedRows
	*
	* @param int $connectionId
	* @result int
	*
	*/
	public function getAffectedRows(int $connectionId=0) : int
	{
		if ($this->establishConnection($connectionId))
			return $this->connections[$connectionId]->getAffectedRows();
		
		return 0;
		
	}
	
	/*							
	*
	* tableExists
	*
	* @param int $connectionId
	* @param $tableName (string)
	* @result bool
	*
	*/
	public function tableExists(int $connectionId, string $tableName) : bool
	{
		
		if ($this->establishConnection($connectionId))
			return $this->connections[$connectionId]->tableExists($tableName);
		
		return FALSE;
		
	}
	
	/*							
	*
	* executeQuery
	*
	* @param int $connectionId
	* @param $query (string)
	* @param $params (array)
	*
	*/
	public function executeQuery(int $connectionId, string $query, ...$params) : void
	{
	
		if ($this->establishConnection($connectionId))
			$this->connections[$connectionId]->executeQuery($query, ...$params);
			
	}
	
	/*
	*
	* executeScalar
	*
	* Executes a query that returns a single value or array
	*
	* @param int $connectionId
	* @param $query (string)
	* @param $params (array)
	* @return array|false
	*
	*/
	public function executeScalar(int $connectionId, string $query, ...$params) /* array|false */
	{
		
		if ($this->establishConnection($connectionId))
			return $this->connections[$connectionId]->executeScalar($query, ...$params);
		
		return FALSE;
		
	}
		
	/*
	*
	* executeReader
	*
	* Executes a query that returns multiple arrays
	*
	* @param int $connectionId
	* @param $query (string)
	* @param $params (array)
	* @return array|false
	*
	*/
	public function executeReader(int $connectionId, string $query, ...$params) /* array|false */
	{
		
		if ($this->establishConnection($connectionId))
			return $this->connections[$connectionId]->executeReader($query, ...$params);
		
		return FALSE;
		
	}
	
	/*
	*
	* executeUpdateArray
	*
	* Parses an array into a query and executes it (useful when having a lot of fields)
	*
	* @param int $connectionId
	* @param $action INSERT|UPDATE
	* @param $table (the table name)
	* @param $data (array)
	* @param $id_field (string)
	* @param $id_value (string)
	*
	* @return void
	*
	*/
	public function executeArray(int $connectionId, string $action, string $table, array $data, string $id_field='', string $id_value='')
	{
		
		if ($this->establishConnection($connectionId))
			$this->connections[$connectionId]->executeArray($action, $table, $data, $id_field, $id_value);
	
	}
	
	/*
	*
	* executeInstall
	*
	* @param int $connectionId
	* @return bool
	*
	*/
	public function executeInstall(int $connectionId=0) : bool
	{
	
		if ($this->establishConnection($connectionId)) {
		
			$filePath = Tools::buildPath(2, $this->config::CONST_DB_INSTALL);
		
			if (file_exists($filePath)) {
				$sql = file_get_contents($filePath);
				$this->connections[$connectionId]->executeQuery($sql);
				return TRUE;
			}
		
		}
		
		return FALSE;
		
	}
	
}