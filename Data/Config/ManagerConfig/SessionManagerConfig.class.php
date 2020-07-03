<?php
namespace phramework;
use phramework;

/**
*
* SessionManagerConfig
*
* 
*
* @author Fhiz
*
*/
class SessionManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "SessionManagerEventResolver";
	
	public const CONST_SESSION_LIFETIME		= 21600;
	public const CONST_SESSION_PREFIX 		= "ph";
	public const CONST_SESSION_PATH			= "/Session/";					// file save path of sessions
	public const CONST_SESSION_DOMAIN		= "";							// set to project domain
	public const CONST_SESSION_SECURE		= false;						// set to true if https is available
	public const CONST_SESSION_HTTPONLY		= true;
	public const CONST_SESSION_SUFFIX 		= "_Session";

}