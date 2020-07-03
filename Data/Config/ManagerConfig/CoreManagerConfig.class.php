<?php
namespace phramework;
use phramework;

/**
*
* CoreManagerConfig
*
* Holds all basic data required for instantiating Managers.
*
* @author Fhiz
* @version 1.0
*
*/
class CoreManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
	
	/*
	* The managers in this list are always loaded by default
	*/
	public const CONST_MANAGERS = array(
	
										"HeaderManager",
										"InputManager",
										"CookieManager",
										"SessionManager",
										"FileCacheManager",
										"DatabaseManager",
										"LanguageManager",
										"AccountManager",
										"TaskManager",
										"MailManager",
										"TemplateManager",
										
										"RouterManager"
										
										);

}