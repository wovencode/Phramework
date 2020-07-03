<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class PageFooterPageletConfig extends BasePageletConfig
{
	
	
	
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		/*
		* Pagelet Template (Required)
		*/
		$this->templateName = "PageFooterPagelet";
		
		/*
		* Tokens
		*/
		$this->tokenNames['public-root-link'] = self::getMediaCDN('.');
		
		parent::__construct(); // Required!
	
	}
	
}