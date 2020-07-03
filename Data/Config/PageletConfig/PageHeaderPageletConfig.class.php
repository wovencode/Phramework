<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class PageHeaderPageletConfig extends BasePageletConfig
{
	
	
	
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct()
	{
		
		/*
		* Pagelet Template (Required)
		*/
		$this->templateName = "PageHeaderPagelet";
		
		/*
		* Tokens
		*/
		$this->tokenNames['public-root-link'] 	= self::getMediaCDN('.');
		$this->tokenNames['title'] 				= self::CONST_ROOT;
		
		/*
		* Data
		*/
		$this->data[] = '<link rel="stylesheet" href="' . self::getMediaCDN('.') . '/Plugins/animate.css/animate.min.css">';
		
		parent::__construct(); // Required!
	}
	
}