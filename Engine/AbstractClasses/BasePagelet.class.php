<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BasePagelet extends BaseParseable
{
	
	/**
	*
	* Constructor
	*
	* @param CoreManager $core
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		parent::__construct($core);
		
		$this->directoryName = $this->config::CONST_PAGELET;
		
	}
	
}