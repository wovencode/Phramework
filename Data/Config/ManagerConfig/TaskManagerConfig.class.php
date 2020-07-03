<?php
namespace phramework;
use phramework;

/**
*
* TaskManagerConfig
*
* 
*
* @author Fhiz
* @version 1.0
*
*/
class TaskManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
		
	/*
	* The tasks in this list are always executed by default
	*/
	public const CONST_SYSTEM_TASKS = array(
	
												"TaskPruneUnconfirmedAccounts",
												"TaskPruneBannedAccounts",
												"TaskPruneDeletedAccounts",
												"TaskRemindUnconfirmedAccounts",
												"TaskPruneUnusedAvatars"
											);
		
}