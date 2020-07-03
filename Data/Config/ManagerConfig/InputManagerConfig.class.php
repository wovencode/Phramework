<?php
namespace phramework;
use phramework;

/**
*
* InputManagerConfig
*
* 
*
* @author Fhiz
*
*/
class InputManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
	
	public const CONST_INTEGER_MIN			= 0;
	public const CONST_INTEGER_MAX			= 99999;
	
	public const CONST_FILESIZE_MAX			= 50000;
	
	public const CONST_FILETYPES_IMAGE = 	[
	 										'jpg' => 'image/jpeg',
            								'png' => 'image/png',
           									'gif' => 'image/gif'
											];
	
	public const CONST_NAME_CONTAINER		= 'Input';
	public const CONST_PREFIX_CHECKSUM		= 'cs_';
	public const CONST_NAME_KEY_CHECKSUM	= 'cs';
	public const CONST_NAME_KEY_CSRF		= 'csrf';
	
}