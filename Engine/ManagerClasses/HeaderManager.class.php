<?php
namespace phramework;
use phramework;

/**
*
* HeaderManager
*
* 
*
* @author Fhiz
* @version 1.0
*
*/
final class HeaderManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "HeaderManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		$this->setCharset();
		$this->setTimezone();
		$this->setHeaders();
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
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/*
	*
	* setHeaders
	*
	*/
	private function setHeaders()
	{
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting($this->config::CONST_ERROR_REPORTING);
		header($this->config::CONST_CACHE_CONTROL); 
		header($this->config::CONST_PRAGMA);
		ob_start();
	}
	
	/*
	*
	* setTimezone
	*
	* sets the current timezone if not set already by php.ini
	*
	*/
	protected function setTimezone()
	{
		
		$defaultTimezone = date_default_timezone_get();
		
		if (empty($defaultTimezone) && !empty($this->config::CONST_TIMEZONE)) {
			date_default_timezone_set($this->config::CONST_TIMEZONE);
		}
		
	}
	
	/*
	*
	* setCharset
	*
	*/
	protected function setCharset()
	{
		if (!empty($this->config::CONST_CHARSET))
			ini_set('default_charset', $this->config::CONST_CHARSET);
	}
	
	
}