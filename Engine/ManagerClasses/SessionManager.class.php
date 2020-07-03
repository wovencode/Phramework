<?php
namespace phramework;
use phramework;

/**
*
* SessionManager
*
* 
*
* @author Fhiz
* @version 1.0
*
*/
final class SessionManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	public ?Session $session = NULL;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName 		= "SessionManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		$this->setSessionSavePath();
		$this->session = new Session($this->core);
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
	
	/**
	*
	* setSessionSavePath
	*
	*/
	private function setSessionSavePath()
	{
	
		$sessionPath = ini_get('session.save_path');
		
		if (empty($sessionPath)) {
			$sessionPath = Tools::buildPath(2, "", "", array($this->config::CONST_TEMP, $this->config::CONST_SESSION_PATH));
			ini_set('session.save_path', $sessionPath);
		}
	
	
	}
	
	
	/*
	* ====================================================================================
	*									PUBLIC FUNCTIONS
	* ====================================================================================
	*/
	
	/**
	*
	* destroySession
	*
	*/
	public function destroySession()
	{
		session_destroy();
	}
	
	/*
	* ====================================================================================
	*									WRAPPER FUNCTIONS
	* ====================================================================================
	*/
	
	/**
	*
	* getContainer (Wrapper)
	*
	*/
	public function getContainer(string $containerName)
	{
		return $this->session->getContainer($containerName);
	}
	
	/**
	*
	* getContainerValue (Wrapper)
	*
	*/
	public function getContainerValue(string $containerName, string $keyName)
	{
		return $this->session->getContainerValue($containerName, $keyName);
	}
	
	/**
	*
	* setContainer (Wrapper)
	*
	*/
	public function setContainer(string $containerName, string $keyName, $keyValue)
	{
		$this->session->setContainer($containerName, $keyName, $keyValue);
	}
	
}