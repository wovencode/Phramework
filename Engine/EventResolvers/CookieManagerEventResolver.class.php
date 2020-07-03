<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class CookieManagerEventResolver extends BaseEventResolver
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
	* ACCOUNT EVENTS
	*
	*/
	
	/**
	*
	* onAccountLoaded
	*
	* This will update the cookie if no cookie has been set. Cookie could have been deleted
	* in the meantime or data was retrieved from the session instead etc.
	*
	*/
	public function onAccountLoaded(int $accountId)
	{
	
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
		
		$this->parent->updateCookie($accountId);
		
	}
	
	/**
	*
	* onAccountLogin
	*
	*/
	public function onAccountLogin(int $accountId)
	{
		
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
			
		$this->parent->updateCookie($accountId);
		
	}
	
	/**
	*
	* onAccountLogout
	*
	*/
	public function onAccountLogout(int $accountId)
	{
	
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
		
		$this->parent->resetCookie($accountId);
	}
	
	/**
	*
	* onAccountResetPassword
	*
	*/
	public function onAccountResetPassword()
	{
	
		/*
		* Always applies to the main account (ID0)
		*/
		$this->parent->resetCookie(0);
		
	}
	
	/**
	*
	* onAccountChangePassword
	*
	*/
	public function onAccountChangePassword(int $accountId)
	{
	
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
		
		$this->parent->resetCookie($accountId);
	}
	
	
}