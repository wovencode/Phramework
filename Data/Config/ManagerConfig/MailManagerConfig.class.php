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
		
	public const CONST_MAIL_EMAIL 				= 'test@wovencode.net';
	public const CONST_MAIL_ECONST_MAIL_REPLY	= 'support@wovencode.net';
	public const CONST_MAIL_ECONST_MAIL_FROM	= 'support@wovencode.net';
	public const CONST_MAIL_HOST				= 'imap.1und1.de';
	public const CONST_MAIL_PORT				= '993';
	public const CONST_MAIL_PASSWORD			= 'BaBw5lCAEKVVzPvvW1H!';
	
	/*
	* Do not change anything below unless you know what you are doing!
	*/
	public string $eventResolver 		= "MailManagerEventResolver";
	
}