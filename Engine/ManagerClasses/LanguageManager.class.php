<?php
namespace phramework;
use phramework;

/**
*
* EmptyManager
*
* 
*
* @author Fhiz
*
*/
final class LanguageManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected array $languages = array();
	protected array $profanity = array();
	protected string $language = "";
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "LanguageManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
	
		if (empty($this->language))
			$this->resetLanguage();
			
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	*/
	public function initializeLate() : void
	{
		
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/*
	* 
	* initializeLanguageData
	*
	*
	*/
	private function initializeLanguageData()
	{
		
		$this->languages = array();
		
		foreach ($this->config->data as $language)
		{
			if (Tools::startsWith($language, $this->language))
			{
				$className = __NAMESPACE__ . "\\" . $language;
				$this->languages[$language] = new $className();
			}
		}
				
	}
	
	/*
	* 
	* initializeProfanityData
	*
	*
	*/
	private function initializeProfanityData()
	{
		
		$this->profanity = array();
		
		foreach ($this->config->languages as $key => $value)
		{
			$className = __NAMESPACE__ . "\\" . $key . "ProfanityList";
			if (class_exists($className))
				$this->profanity[$key] = new $className();	
		}
				
	}
	
	/**
	*
	* getLanguageName
	*
	* Returns a fully assemble language name
	*
	* @return string
	*
	*/
	private function getLanguageName(string $mainCategory='', $subCategory=0) : string
	{
	
		if (empty($mainCategory))
			$mainCategory = $this->config::CONST_SYSTEM;
		
		return $this->language . $mainCategory . "Language";
	
	}
	
	/*
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* checkProfanity
	*
	* Checks if a given text contains profanity
	*
	* @return bool
	*
	*/
	public function checkProfanity(string $text) : bool
	{
		$this->initializeProfanityData();
		
		foreach ($this->profanity as $profanity)
		{
			if (Tools::substr_in_array($text, $profanity->data))
				return true;
		}
		
		return false;
		
	}
	
	/**
	*
	* getLanguage
	*
	* Translates a language key into a actual language word or text
	*
	* @return string
	*
	*/
	public function getLanguage($key, string $mainCategory='', $subCategory=0) : string
	{
		
		$languageName = $this->getLanguageName($mainCategory, $subCategory);
		
		return $this->languages[$languageName]->data[$key];
	}
	
	
	/**
	*
	* hasLanguage
	*
	* Checks if the given language exists
	*
	* @return bool
	*
	*/
	public function hasLanguageKey($key, string $mainCategory='', $subCategory=0) : bool
	{
		
		$languageName = $this->getLanguageName($mainCategory, $subCategory);
		
		return (array_key_exists($key, $languageName));
		
	}
	
	/**
	*
	* hasLanguage
	*
	* Checks if the given language exists
	*
	* @return bool
	*
	*/
	public function hasLanguage($language) : bool
	{
		return (array_key_exists($language, $this->config->languages));
	}
	
	/**
	*
	* getDefaultLanguage
	*
	* @return string
	*
	*/
	public function getDefaultLanguage() : string
	{
		return $this->config::CONST_DEFAULT_LANGUAGE;
	}
	
	/**
	*
	* setLanguage
	*
	* Temporarily changes the display language to another language
	*
	*/
	public function setLanguage($language)
	{
		if ($this->hasLanguage($language) && $this->language != $language) {
			$this->language = $language;
			$this->initializeLanguageData();	
		} else {
			$this->resetLanguage();
		}
	}
	
	/**
	*
	* resetLanguage
	*
	* Resets the display language to the default language
	*
	*/
	public function resetLanguage()
	{
		$this->language = $this->config::CONST_DEFAULT_LANGUAGE;
		$this->initializeLanguageData();
	}
	
	/**
	*
	* getLanguages
	*
	* Returns all available languages
	*
	*/
	public function getLanguages() : array
	{
		return $this->config->languages;
	}
	
	/**
	*
	* getLanguage
	*
	* Returns the currently selected language key
	*
	*/
	public function getCurrentLanguage() : string
	{
		return $this->language;
	}
	
	/**
	*
	* getLanguageName
	*
	* Returns the currently selected language name
	*
	*/
	public function getCurrentLanguageName() : string
	{
		
		return $this->config->languages[$this->language];
	}
	
}