<?php
namespace phramework;
use phramework;

/**
*
* BaseConfig
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseConfig
{
	
	/*
	* Class Variables
	*/
	
	/*
	* Project Domain (Required)
	* The domain the root directory is located in (including http://)
	*/
	public const CONST_DOMAIN		= "http://wovencode.net";
	
	/*
	* Root Directory (Required)
	* Name of the applicatons root directory
	*/
	public const CONST_ROOT			= "Phramework";
	
	/* 
	* MEDIA CDN (Optional) 
	* Domain from which public content (e.g. images) is served,
	* leave empty to use the domain your application is hosted.
	*/
	public const CONST_CDN_MEDIA	= "";				
	
	/* 
	* UPLOAD CDN (Optional) 
	* Domain from which uploaded content (e.g. avatars) is served,
	* leave empty to use the domain your application is hosted.
	*
	* ATTENTION: You have to set the access rights of the target
	* directory to 711 - which is not secure! In addition you should
	* add a .htaccess to limit access to your remote domains only.
	*
	*/
	public const CONST_CDN_UPLOAD	= "";	
	
	/*
	* Do not change anything below this line - unless you know what you are doing!
	*/
	
	public const CONST_DATA 		= "Data";
	public const CONST_CONFIG		= "Config";
	public const CONST_LANG			= "Lang";
	public const CONST_LANGUAGE		= "Languages";
	public const CONST_MAIL			= "Mail";
	public const CONST_TEMPLATES	= "Templates";
	public const CONST_PAGE			= "Pages";
	public const CONST_PAGELET		= "Pagelets";
	public const CONST_SLOT			= "Slots";
	public const CONST_ICONS		= "Icons";
	public const CONST_AVATARS		= "Avatars";
	public const CONST_ENGINE 		= "Engine";
	public const CONST_PUBLIC		= "Public";
	public const CONST_MEDIA		= "Media";
	public const CONST_PLUGINS		= "Plugins";
	public const CONST_TEMP			= "Temp";
	public const CONST_SYSTEM		= "System";
	
	public string $eventResolver 	= "";
	
	/**
	*
	* Constructor
	*
	*/
    public function __construct()
	{
				
	}
	
	/**
	*
	* getMediaCDN
	*
	* Returns the MEDIA CDN (if any) otherwise returns default string
	*
	* @return string
	*
	*/
	public function getMediaCDN(string $default='') : string
	{
		return empty(self::CONST_CDN_MEDIA) ? $default : self::CONST_CDN_MEDIA;
	}
	
	/**
	*
	* getUploadCDN
	*
	* Returns the UPLOAD CDN (if any) otherwise returns default string
	*
	* @return string
	*
	*/
	public function getUploadCDN(string $default='') : string
	{
		return empty(self::CONST_CDN_UPLOAD) ? $default : self::CONST_CDN_UPLOAD;
	}
	
}