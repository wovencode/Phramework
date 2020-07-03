<?php
namespace phramework;
use phramework;

/**
*
* CookieManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class CookieManagerConfig extends BaseConfig
{
	
	public string $eventResolver		= "CookieManagerEventResolver";
	
	public const CONST_COOKIE_NAME 		= "ph_RememberMe";
	public const CONST_COOKIE_EXPIRES 	= 2592000; 				// Seconds (2592000 = 30 days)
	public const CONST_COOKIE_PATH 		= "/";
	public const CONST_COOKIE_DOMAIN	= "";					// Set to project domain for increased security
	public const CONST_COOKIE_SECURE 	= false;				// Set to true if https is available
	public const CONST_COOKIE_HTTPONLY 	= true;
	
	public const CONST_COOKIE_CHECKSUM 	= true;					// Use checksum to ensure cookie data is unmodified?
	
}