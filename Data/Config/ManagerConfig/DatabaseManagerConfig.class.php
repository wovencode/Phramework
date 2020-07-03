<?php
namespace phramework;
use phramework;

/**
*
* DatabaseManagerConfig
*
* Holds all basic database configuration credentials and options.
*
* @author Fhiz
*
*/
class DatabaseManagerConfig extends BaseConfig
{
	
	public const CONST_DATABASES = 
	[
			/*
			* First database is used for regular game data
			*/
			array(
				'driver' 	=> 'mysql',
				'host' 		=> 'localhost',
				'name' 		=> 'db822006023',
				'user' 		=> 'dbo822006023',
				'password' 	=> '>,4A:<}cmlf3fQ6rFH1ySI',
				'charset' 	=> 'utf8mb4',
				'port' 		=> 3306
			),
			/*
			* Second database is used for Account data
			* This database is optional you can also put the first database credentials in there
			* Second database allows you to store accounts for multiple games in a central place
			*/
			array(
				'driver' 	=> 'mysql',
				'host' 		=> 'localhost',
				'name' 		=> 'db669976274',
				'user' 		=> 'dbo669976274',
				'password' 	=> '<;3B,>{dcbt9dZ3nGU8xOJ',
				'charset' 	=> 'utf8mb4',
				'port' 		=> 3306
			)	
	];
	
	/*
	* Only needs to be modified if the location of the install file changed.
	*/
	public const CONST_DB_INSTALL		= "Install/install.sql";
	
	/*
	* Do not change anything below unless you know what you are doing!
	*/
	public string $eventResolver = "";
	
}