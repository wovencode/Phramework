<?php
namespace phramework;
use phramework;

/**
*
* BasePageConfig
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BasePageConfig extends BaseParseableConfig
{
	
	/**
	*
	* Constructor
	*
	*/
    public function __construct()
	{
		
		$this->tokenNames['page-content'] = '';
		
		/*
		* Tokens
		*
		* theme-dark
		*
		* color-red
		* color-green
		* color-blue
		* color-pink
		* color-yellow
		* color-orange
		* color-purple
		* color-deeppurple
		* color-lightblue
		* tcolor-eal
		* color-lime
		* color-deeporange
		* color-gray
		* color-white
		* color-black
		*
		* See more information about colors and how to add custom colors here:
		*
		* https://framework7.io/docs/color-themes.html
		*
		*/
		$this->tokenNames['html-class'] = ''; #theme-dark
		$this->tokenNames['body-color'] = 'color-theme-gray';
		$this->tokenNames['body-class'] = ''; #theme-dark
		
		/*
		* Caches
		*/
		$this->cacheNames =
		[
			"TemporaryCache"
		];
		
		/*
		* Meta Pagelets
		*/
		$this->metaNames =
		[
			"PageHeaderPagelet",
			"PageFooterPagelet"
		];
		
		parent::__construct(); // Required!
				
	}
	
}