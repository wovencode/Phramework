<?php
namespace phramework;
use phramework;

/**
*
* ModalWindowConfig
*
* @author Fhiz
* @version 1.0
*
*/
class ModalWindowPageletConfig extends BasePageletConfig
{
	
	/*
	* Class Variables
	*/
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "ModalWindowPagelet";
		
		parent::__construct();
	}
	
}