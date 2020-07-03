<?php
namespace phramework;
use phramework;

/**
*
* LanguageManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class LanguageManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "LanguageManagerEventResolver";
	
	public array $languages = array();
	
	public const CONST_DEFAULT_LANGUAGE		= "English";
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->data[] = "EnglishMailLanguage";
		$this->data[] = "EnglishSystemLanguage";
		
		$this->data[] = "GermanMailLanguage";
		$this->data[] = "GermanSystemLanguage";
		
		$this->languages['English'] 	= 'English';
		$this->languages['German'] 		= 'Deutsch';
		
		
	}
	
}