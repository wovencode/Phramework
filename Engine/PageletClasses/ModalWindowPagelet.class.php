<?php
namespace phramework;
use phramework;

/**
*
* ModalWindowPagelet
*
* @author Fhiz
* @version 1.0
*
*/
class ModalWindowPagelet extends BasePagelet
{
	
	/*
	* Class Variables
	*/
	protected bool $active = true;
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "ModalWindowPageletConfig";
		
		parent::__construct($core);
	
	}
	
	/**
	*
	* buildTemplate (Overridden)
	*
	* Rebuilds the template from scratch and returns it.
	*
	* @param array $templateTokens
	* @return string
	*
	*/
	public function buildTemplate(string $templateName, array $templateTokens=array()) : string
	{
		
		if (!$this->active)
			return '';
			
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
	/**
	*
	* buildPopup
	*
	*
	*
	*/
	public function buildPopup(string $headerName, string $footerName, string $slotName)
	{
		
		$this->templateTokens['class'] = '';
		$this->templateTokens['header'] = '';
		$this->templateTokens['footer'] = '';
		
		if (!empty($footerName))
			$this->templateTokens['footer'] = $this->core->notifyMediator("LanguageManager", "getLanguage", $footerName);
		
		if (!empty($headerName))
			$this->templateTokens['header'] = $this->core->notifyMediator("LanguageManager", "getLanguage", $headerName);
		
		$slotTokens = array();
		$slotTokens['size'] = 96;
		
		$this->templateTokens['content'] = $this->core->notifyMediator("TemplateManager", "parseTemplate", $slotName, $slotTokens, $this->config::CONST_SLOT);
		
	}
	
	/**
	*
	* buildPopup
	*
	*
	*
	*/
	public function removePopup()
	{
		$this->active = false;
	}
	
}