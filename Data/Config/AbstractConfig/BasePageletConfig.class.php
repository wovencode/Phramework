<?php
namespace phramework;
use phramework;

/**
*
* BasePageletConfig
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BasePageletConfig extends BaseParseableConfig
{
	
	/*
	* Prefab Slot name
	*/
	#public string $slotName = "";
	
	/**
	*
	* Constructor
	*
	*/
    public function __construct()
	{
		parent::__construct(); // Required!
	}
	
}