<?php
namespace phramework;
use phramework;

/**
*
* HeaderManagerConfig
*
* 
*
* @author Fhiz
*
*/
class HeaderManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
	
	public const CONST_TIMEZONE			= ""; 						// leave empty to use default timezone (e.g. Europe/Berlin)
	public const CONST_CHARSET			= "UTF-8"; 					// leave empty to use charset from php.ini
	public const CONST_CACHE_CONTROL	= "Cache-Control: no-cache, must-revalidate";
	public const CONST_PRAGMA			= "Pragma: no-cache";
	public const CONST_ERROR_REPORTING 	= 32767; 					// see: https://www.php.net/manual/de/errorfunc.constants.php
	
}