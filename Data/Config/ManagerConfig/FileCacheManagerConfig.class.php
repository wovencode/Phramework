<?php
namespace phramework;
use phramework;

/**
*
* FileManagerCacheConfig
*
* @author Fhiz
* @version 1.0
*
*/
class FileCacheManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
	
	public const CONST_CACHE_CHECK_CHANCE 	= 5;
	public const CONST_CACHE_DURATION		= "-60 minutes";
	public const CONST_CACHE_EXTENSION		= ".cache";
	public const CONST_CACHE_DIRECTORY		= "Cache";
	
}