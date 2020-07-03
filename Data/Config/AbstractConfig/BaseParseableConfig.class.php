<?php
namespace phramework;
use phramework;

/**
*
* BaseParseableConfig
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseParseableConfig extends BaseConfig
{
	
	public bool $isCached 				= false;					// Is the page cached after it has been build once?
	public bool $accessLoggedIn 		= false;					// Must be logged in to see this page?
	public bool $accessLoggedOut 		= false;					// Must be logged out to see this page?
	public bool $accessConfirmed		= true;
	public bool $accessUnconfirmed		= true;
	public bool $isRiskyAction			= false;
	public int 	$minAdminLevel			= 0;
	
	public bool $redirectWhenLoggedIn 	= false;					// Redirect the client when logged in (instead of displaying the page)?
	
	public string $templateName 		= '';						// string: template name
	
	public string $slotName				= '';						// string: slot prefab name
	public string $slotNameSuccess		= 'CheckmarkF7Icon.slot';
	public string $slotNameFailure		= 'XmarkF7Icon.slot';
	
	public array $metaNames 			= array();					// array (string): meta names
	public array $pageletNames 			= array();					// array (string): pagelet names
	public array $tokenNames 			= array();					// array (string): token names for fixed page tokens
	public array $cacheNames 			= array();					// array (string): cache names for page sub cache
	public array $segmentNames 			= array();					// array (string): segment names for multi segment pages/pagelets
	public array $languageNames 		= array();					// array (string) : language names for language tokens
	
	/**
	*
	* Constructor
	*
	*/
    public function __construct()
	{
		
		/*
		* When unsegmented, the template name is the first segments name
		*/
		if (!$this->hasSegments())
			$this->segmentNames[$this->templateName] = $this->templateName;
			
	}
	
	/**
	*
	* hasMetas
	*
	* @return bool
	*
	*/
	public function hasMetas() : bool
	{
		return count($this->metaNames) > 0;
	}
	
	/**
	*
	* hasPagelets
	*
	* @return bool
	*
	*/
	public function hasPagelets() : bool
	{
		return count($this->pageletNames) > 0;
	}
	
	/**
	*
	* hasTokens
	*
	* @return bool
	*
	*/
	public function hasTokens() : bool
	{
		return count($this->tokenNames) > 0;
	}
	
	/**
	*
	* hasCaches
	*
	* @return bool
	*
	*/
	public function hasCaches() : bool
	{
		return count($this->cacheNames) > 0;
	}
	
	/**
	*
	* hasSegments
	*
	* @return bool
	*
	*/
	public function hasSegments() : bool
	{
		return count($this->segmentNames) > 0;
	}
	
	/**
	*
	* hasLanguages
	*
	* @return bool
	*
	*/
	public function hasLanguages() : bool
	{
		return count($this->languageNames) > 0;
	}
	
}