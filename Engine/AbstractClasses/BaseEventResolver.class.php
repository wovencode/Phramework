<?php
namespace phramework;
use phramework;

/**
*
* BaseEventResolver
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseEventResolver
{
	
	protected ?CoreManager $core = NULL;
	protected ?object $parent = NULL;
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core=NULL, &$parentClass=NULL)
	{

		if (!is_null($core))
			$this->core = $core;
		
		if (!is_null($parentClass))
			$this->parent = $parentClass;
			
	}
		
}