<?php
namespace phramework;
use phramework;

/**
*
* AccountManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class AccountManagerConfig extends BaseConfig
{
	
	public string $eventResolver 			= "AccountManagerEventResolver";
	
	
	public const CONST_RISKY_ACTION_DELAY	= 1;				// Delay between "risky actions" in minutes
	public const CONST_TOKEN_EXPIRATION		= 10;				// Time in minutes until tokens expire
	
	public const CONST_MINLENGTH_ACCOUNT 	= 4;				// Minimum length of account names
	public const CONST_MAXLENGTH_ACCOUNT	= 16;				// Maximum length of account names
	
	public const CONST_MINLENGTH_PASSWORD 	= 4;				// Minimum length of passwords
	public const CONST_MAXLENGTH_PASSWORD	= 16;				// Maximum length of passwords
	
	public const CONST_PASSWORD_UPPERCASE 	= false;			// Passwords must contain a uppercase character
	public const CONST_PASSWORD_LOWERCASE 	= false;			// Passwords must contain a lowercase character
	public const CONST_PASSWORD_NUMERIC 	= false;			// Passwords must contain a number
	public const CONST_PASSWORD_SPECIALCHAR = false;			// Passwords must contain a special character
	
}