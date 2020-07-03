<?php
namespace phramework;
use phramework;

/**
*
* FileCacheManager
*
* @author Fhiz
* @version 1.0
*
*/
final class FileCacheManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected array $tempCaches = array();
	protected \RecursiveDirectoryIterator $directoryIterator;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "FileCacheManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		$this->clearFileCache();
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	*/
	public function initializeLate() : void
	{
	
	}
	
	/*
	* ====================================================================================
	*                                    PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* setFileCache
	*
	* Caches the provided content to a temporary file of the provided name
	*
	*
	*/
	public function setFileCache(string $cacheName, string $cacheContent, string $cacheDirectory)
	{
		
		/*
		* Give a small chance to check the cached files for expiration
		*/
		self::clearFileCache($this->config::CONST_CACHE_CHECK_CHANCE);
		
		if (!Tools::mempty($cacheName, $cacheContent))
		{
			$filePath = Tools::buildPath(2, $cacheName, $this->config::CONST_CACHE_EXTENSION, array($this->config::CONST_TEMP, $this->config::CONST_CACHE_DIRECTORY, $cacheDirectory));
			file_put_contents($filePath, $cacheContent);
		}
		
	}
	
	/**
	*
	* getFileCache
	*
	*
	* @return string
	*
	*/
	public function getFileCache(string $cacheName, string $cacheDirectory) : string
	{
	
		if (self::checkFileCache($cacheName, $cacheDirectory))
		{
			$filePath = Tools::buildPath(2, $cacheName, $this->config::CONST_CACHE_EXTENSION, array($this->config::CONST_TEMP, $this->config::CONST_CACHE_DIRECTORY, $cacheDirectory));
			return file_get_contents($filePath);
		}
		
		return NULL;
	}
	
	/**
	*
	* checkFileCache
	*
	* checks if a cached file of the provided name exists and is still valid
	*
	* @result bool
	*
	*/
	public function checkFileCache(string $cacheName, string $cacheDirectory) : bool
	{
	
		/*
		* Give a small chance to check the cached files for expiration first
		*/
		self::ClearFileCache($this->config::CONST_CACHE_CHECK_CHANCE);
		
		if (!empty($cacheName))
		{
			
			$filePath = Tools::buildPath(2, $cacheName, $this->config::CONST_CACHE_EXTENSION, array($this->config::CONST_TEMP, $this->config::CONST_CACHE_DIRECTORY, $cacheDirectory));
			
			if (is_file($filePath))
				return true;
		}
		
		return false;
		
	}
	
	/**
	*
	* clearFileCache
	*
	* Clears the template cache directory file by file when enough time has passed
	*
	*/
	protected function clearFileCache(int $checkChance=100)
	{
		
		/*
		* First, check the percentage chance if the ClearCache function does run
		*/
		if (Tools::ProbabilityCheck($checkChance))
		{
		
			$directory = Tools::buildPath(2, "", "", array($this->config::CONST_TEMP, $this->config::CONST_CACHE_DIRECTORY));
			
			// Recursively search all directories	
			$this->directoryIterator = new \RecursiveDirectoryIterator($directory);
			
			foreach (new \RecursiveIteratorIterator($this->directoryIterator) as $file)
			{
			
				if (filetype($file) != "dir")
				{
					if (strtotime($this->config::CONST_CACHE_DURATION) > @filemtime($file))
					{
						@unlink($file);
					}
				}
				
			}
					
		}
		
	}
	
	/*
	* ====================================================================================
	*                                  TEMPORARY CACHE
	* ====================================================================================
	*/
	
	/**
	*
	* addTempCache
	*
	* 
	*
	*/
	public function addTempCache(string $key, string $content)
	{
		if (isset($this->tempCaches[$key]))
		{
			$this->tempCaches[$key] .= $content;
		} else {
			$this->tempCaches[$key] = $content;
		}
	}
	
	/**
	*
	* flushTempCache
	*
	* 
	*
	*/
	public function flushTempCache(string $key) : string
	{
		
		$content = '';
		
		if (isset($this->tempCaches[$key]))
		{
			$content = $this->tempCaches[$key];
		}
		
		self::clearTempCache($key);
		
		return $content;
		
	}
	
	/**
	*
	* clearTempCache
	*
	* 
	*
	*/
	protected function clearTempCache(string $key)
	{
		if (empty($key)) {
			$this->tempCaches = array();
		} else {
			if (isset($this->tempCaches[$key]))
				$this->tempCaches[$key] = '';
		}
	}
		
}