<?php
namespace phramework;
use phramework;

/**
*
* AccountManagerEventResolver
*
* @author Fhiz
* @version 1.0
*
*/
class AccountManagerEventResolver extends BaseEventResolver
{

	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core, &$parentClass=NULL)
	{
		parent::__construct($core, $parentClass);
	}
	
	/**
	*
	* COOKIE EVENTS
	*
	*/
	
	/**
	*
	* onCookieReset 
	*
	*/
	public function onCookieReset(int $accountId)
	{
		
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
				
		$this->parent->refreshLoginToken($accountId);
		
	}

}