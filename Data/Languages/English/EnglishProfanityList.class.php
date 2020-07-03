<?php
namespace phramework;
use phramework;

/**
*
* EnglishProfanityList
*
* 
*
*
* @author Fhiz
* @version 1.0
*
*/
class EnglishProfanityList
{
	
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->data[] 	= 'cunt';
		$this->data[] 	= 'cock';
		$this->data[] 	= 'nigger';
		$this->data[] 	= 'nigga';
		$this->data[] 	= 'shit';
		
	}
	
}