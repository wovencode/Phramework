<?php
namespace phramework;
use phramework;

/**
*
* EventDispatcherConfig
*
* @author Fhiz
* @version 1.0
*
*/
class EventDispatcherConfig /* extends BaseConfig*/
{
	
	public $events = array();
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct()
	{
	
		$this->events = array();
		
		$this->events['onAccountLoaded'] 			= 'onAccountLoaded';
		$this->events['onAccountUpdate'] 			= 'onAccountUpdate';
		$this->events['onAccountSave'] 				= 'onAccountSave';
		$this->events['onAccountLogin'] 			= 'onAccountLogin';
		$this->events['onAccountLogout'] 			= 'onAccountLogout';
		$this->events['onAccountRegister'] 			= 'onAccountRegister';
		$this->events['onAccountDelete'] 			= 'onAccountDelete';
		$this->events['onAccountBan'] 				= 'onAccountBan';
		$this->events['onAccountConfirm'] 			= 'onAccountConfirm';
		$this->events['onAccountChangeEmail'] 		= 'onAccountChangeEmail';
		$this->events['onAccountChangePassword'] 	= 'onAccountChangePassword';
		
		$this->events['onCookieReset'] 				= 'onCookieReset';
		
		
		
		
	}
	
	
}