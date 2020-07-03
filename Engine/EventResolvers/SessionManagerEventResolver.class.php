<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class SessionManagerEventResolver extends BaseEventResolver
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
	* onAccountLoaded
	*
	*/
	public function onAccountLoaded(int $accountId)
	{
		
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
			
		if (!$this->parent->session->isContainer('Account'))
		{
		
			$this->parent->session->createContainer('Account');
			
			$data = $this->core->notifyMediator("AccountManager", "getAccountTemporaryData", $accountId);
			
			foreach ($data as $key => $value)
				$this->parent->session->setContainer('Account', $key, $value);
		}
	}
	
	/**
	*
	* onAccountSave
	*
	*/
	public function onAccountSave(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountUpdate
	*
	*/
	public function onAccountUpdate(int $accountId)
	{
		
		/*
		* Only applies to the main account (ID0)
		*/
		if ($accountId != 0)
			return;
			
		$data = $this->core->notifyMediator("AccountManager", "getAccountTemporaryData", $accountId);
		
		foreach ($data as $key => $value)
			$this->parent->session->setContainer('Account', $key, $value);
			
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
			
		$this->parent->session->regenerateSession();
		$this->parent->session->destroyContainer('Account');
		$this->parent->session->createContainer('Account');
		
		$data = $this->core->notifyMediator("AccountManager", "getAccountTemporaryData", $accountId);
		
		foreach ($data as $key => $value)
			$this->parent->session->setContainer('Account', $key, $value);
		
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
		
		$this->parent->destroySession();
		
	}
	
	/**
	*
	* onAccountRegister
	*
	*/
	public function onAccountRegister(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountDelete
	*
	*/
	public function onAccountDelete(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountBan)
	*
	*/
	public function onAccountBan(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountConfirm
	*
	*/
	public function onAccountConfirm(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountChangeEmail
	*
	*/
	public function onAccountChangeEmail(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountChangePassword 
	*
	*/
	public function onAccountChangePassword(int $accountId)
	{
	
	}
	
	/**
	*
	* COOKIE
	*
	*/
	
	/**
	*
	* onCookieReset 
	*
	*/
	public function onCookieReset(int $accountId)
	{
	
	}

}