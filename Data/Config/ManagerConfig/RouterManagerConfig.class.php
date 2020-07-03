<?php
namespace phramework;
use phramework;

/**
*
* RouterManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class RouterManagerConfig extends BaseConfig
{
	
	public string $eventResolver 		= "";
	
	/*
	* GET variable used as page id
	*/
	public const CONST_PAGE_VARIABLE 	= "p";
	
	/*
	* Default page to revert to when route not found
	*/
	public const CONST_DEFAULT_PAGE		= "IndexPage";
	
	/*
	* List of all routes
	*/
	public $data = array
	(
	
			'InstallPage',
			'IndexPage',
			'HomePage',
			
			'AccessDeniedPage',
			
			'AccountLoginPage',
			'AccountRegisterPage',
			'AccountLogoutPage',
			
			'AccountProfilePage',
			'AccountSettingsPage',
			'AccountListPage',
			'AccountInspectPage',
			
			'AccountConfirmPage',
			'AccountResetPasswordPage',
			'AccountChangePasswordPage',
			'AccountChangeEmailPage',
			'AccountDeletePage'
			
	);
	
}