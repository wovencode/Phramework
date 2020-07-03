<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class LanguageManagerEventResolver extends BaseEventResolver
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
			
		$this->parent->setLanguage($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'language'));
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
			
		$this->parent->setLanguage($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'language'));
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
			
		$this->parent->setLanguage($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'language'));
	}
	
	/**
	*
	* onAccountLogout
	*
	*/
	public function onAccountLogout(int $accountId)
	{
		$this->parent->resetLanguage();
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