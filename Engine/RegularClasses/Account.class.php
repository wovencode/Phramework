<?php
namespace phramework;
use phramework;

/**
*
* Account
*
* @author Fhiz
* @version 1.0
*
*/
final class Account extends BaseObject
{
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		parent::__construct($core); // required!
	}
	
	/**
	*
	* verifyAccount
	*
	*/
	public function verifyAccount(string $name, string $password) : bool
	{
	
		if (!$this->isValid())
			return false;
		
		return (
				$this->database_data['name'] == $name && 
				$this->database_data['deleted'] == 0 &&
				$this->database_data['banned'] == 0 &&
				$this->core->notifyMediator("CipherManager", "verifyPassword", $password, $this->database_data['passwordHash'])
				);
		
	}
	
	
	
}