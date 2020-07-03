<?php
namespace phramework;
use phramework;
use \PDO;

/**
*
* DatabaseConnection
*
* @author Fhiz
* @version 1.0
*
*/
final class DatabaseConnection
{
	
	/*
	* Class Variables
	*/
	private ?\PDO $connection	= NULL;
	private string $dsn			= '';
	private $statement 			= NULL;
	
	private int $queryCount		= 0;
	private array $queries		= array();
	
	private array $options 	=
	[
    	PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    	PDO::ATTR_EMULATE_PREPARES   => false,
	];
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(string $dbDriver, string $dbHost, string $dbName, string $dbCharset, string $dbUser, string $dbPassword, int $dbPort)
	{
		$this->establishConnection($dbDriver, $dbHost, $dbName, $dbCharset, $dbUser, $dbPassword, $dbPort);	
	}
	
	/*
	*
	* Destructor
	*
	*/
	public function __destruct()
	{

	}
	
	/*
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/*
	*
	* checkConnection
	*
	* @return bool
	*
	*/
	public function checkConnection() : bool
	{
		return ($this->connection != NULL);	
	}
	
	/*							
	*
	* establishConnection
	*
	* @return void
	*
	*/
	public function establishConnection(string $dbDriver, string $dbHost, string $dbName, string $dbCharset, string $dbUser, string $dbPassword, int $dbPort) : void
	{
		
		if ($this->checkConnection())
			return;
		
		if (empty($this->dsn))
			$this->dsn = $dbDriver . ":host=" . $dbHost . ";dbname=" . $dbName . ";charset=" . $dbCharset;
		
		try {
     		$this->connection = new \PDO($this->dsn, $dbUser, $dbPassword, $this->options);
		} catch (\PDOException $e) {
			$this->connection = NULL;
     		throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
		
	}
	
	/*							
	*
	* beginTransaction
	*
	* @return void
	*
	*/
	public function beginTransaction() : void
	{
		$this->connection->beginTransaction();
	}
	
	/*							
	*
	* commitTransaction
	*
	* @return void
	*
	*/
	public function commitTransaction() : void
	{
		$this->connection->commit();
	}
	
	/*							
	*
	* getAffectedRows
	*
	* @return int
	*
	*/
	public function getAffectedRows() : int
	{
		return $this->statement->rowCount();
	}
	
	/*							
	*
	* tableExists
	*
	* @param $tableName (string)
	* @return bool
	*
	*/
	public function tableExists(string $tableName) : bool
	{
		
		if (empty($tableName))
			return false;
		
		$query = "SELECT 1 FROM $tableName LIMIT 1";
		
		try {
        	$result = $this->connection->query($query);
    	} catch (\PDOException $e) {
       		// We got an exception == table not found
        	return FALSE;
    	}
		
		$this->trackQuery($query);
		
    	// Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
    	return $result !== FALSE;
	
	}
	
	/*							
	*
	* executeQuery
	*
	* @param $query (string)
	* @param $params (array)
	*
	* @return void
	*
	*/
	public function executeQuery(string $query, ...$params) : void
	{
	
		try {
		
			$this->statement = $this->connection->prepare($query);
			
			if (count($params) > 0) {
				for ($i = 0; $i < count($params); $i++) {
					Tools::log($params[$i]);
    				$this->statement->bindValue($i+1, $params[$i]);
				}
			}
			
			$this->statement->execute();
			
			$this->trackQuery($query);
			
		} catch (\PDOException $e) {
			echo $query . "<br>";
			throw new \PDOException($e->getMessage(), (int)$e->getCode());
		}
		
	}
	
	/*
	*
	* executeScalar
	*
	* Executes a query that returns a single value
	*
	* @param $query (string)
	* @param $params (array)
	* @return array|false
	*
	*/
	public function executeScalar(string $query, ...$params) /* array|false */
	{
		$this->executeQuery($query, ...$params);
		return $this->statement->fetchColumn();
		
	}
		
	/*
	*
	* executeReader
	*
	* Executes a query that returns one or multiple arrays
	*
	* @param $query (string)
	* @param $params (array)
	* @return array|false
	*
	*/
	public function executeReader(string $query, ...$params) /* array|false */
	{
		$this->executeQuery($query, ...$params);
		
		if ($this->getAffectedRows() <= 1)
			return $this->statement->fetch(PDO::FETCH_ASSOC);
		
		return $this->statement->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/*
	*
	* executeUpdateArray
	*
	* Parses an array into a query and executes it (useful when having a lot of fields)
	*
	* @param $action INSERT|UPDATE
	* @param $table (the table name)
	* @param $data (array)
	* @param $id_field (string)
	* @param $id_value (string)
	*
	* @return void
	*
	*/
	public function executeArray(string $action, string $table, array $data, string $id_field='', string $id_value='') : void
	{
		
		if (is_null($data) || empty($data))
			return;
		
		foreach ($data as $field => $value)
		{
			if (stristr($value, "()") != FALSE)
				$fields[] = sprintf("`%s` = %s", $field, $value);
			else
				$fields[] = sprintf("`%s` = '%s'", $field, $value);
		}
				
		$field_list = join(',', $fields);
		
		$query = '';
		
		if (Tools::mempty($id_field, $id_value)) {
			$query = sprintf("%s `%s` SET %s", $action, $table, $field_list);
		} else {
			$query = sprintf("%s `%s` SET %s WHERE `%s` = '%s'", $action, $table, $field_list, $id_field, $id_value);
		}
		
		$this->executeQuery($query);
		
	}
	
	/*
	*
	* getQueryCount
	*
	* @return int
	*
	*/
	public function getQueryCount() : int
	{
		return $this->queryCount;
	}
	
	/*
	*
	* getQueries
	*
	* @return int
	*
	*/
	public function getQueries() : array
	{
		return $this->queries;
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/*
	*
	* trackQuery
	*
	* Tracks the query and increases the query count for statistics usage
	*
	* @param $query (string)
	* @return void
	*
	*/
	private function trackQuery(string $query) : void
	{
		$this->queryCount++;
		$this->queries[] = $query;
	}
	
}