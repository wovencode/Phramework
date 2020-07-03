<?php
namespace phramework;
use phramework;

/**
*
* MailManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class MailManagerConfig extends BaseConfig
{
		
	public const CONST_MAIL_EMAIL 				= '';
	public const CONST_MAIL_ECONST_MAIL_REPLY	= '';
	public const CONST_MAIL_ECONST_MAIL_FROM	= '';
	public const CONST_MAIL_HOST				= '';
	public const CONST_MAIL_PORT				= '993';
	public const CONST_MAIL_PASSWORD			= '';
	
	/*
	* Do not change anything below unless you know what you are doing!
	*/
	public string $eventResolver 		= "MailManagerEventResolver";
	
}