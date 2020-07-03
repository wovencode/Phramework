<?php
namespace phramework;
use phramework;

/**
*
* VirtualCurrencyManagerEventResolver
*
* @author Fhiz
* @version 1.0
*
*/
class VirtualCurrencyManagerEventResolver extends BaseEventResolver
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
	

}