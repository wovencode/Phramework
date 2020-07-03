<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class MailManagerEventResolver extends BaseEventResolver
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
	
	}
	
	/**
	*
	* onAccountLoaded
	*
	*/
	public function onAccountLoaded(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountLogin
	*
	*/
	public function onAccountLogin(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountLogout
	*
	*/
	public function onAccountLogout(int $accountId)
	{
	
	}
	
	/**
	*
	* onAccountRegister
	*
	*/
	public function onAccountRegister(int $accountId)
	{
		$email = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'email');
		$code = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'securityToken');
		$this->parent->sendRegistrationConfirmation($email, $code);
	}
	
	/**
	*
	* onAccountDelete
	*
	*/
	public function onAccountDelete(int $accountId)
	{
		$email = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'email');
		$code = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'securityToken');
		$this->parent->sendDeleteAccount($email, $code);
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
		$email = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'email');
		$code = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'securityToken');
		$this->parent->sendChangeEmail($email, $code);
	}
	
	/**
	*
	* onAccountChangePassword 
	*
	*/
	public function onAccountChangePassword(int $accountId)
	{
		$email = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'email');
		$code = $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'securityToken');
		$this->parent->sendChangePassword($email, $code);
	}
		
}