<?php
namespace phramework;
use phramework;

/**
*
* @author Fhiz
* @version 1.0
*
*/
class PageHeaderPagelet extends BasePagelet
{
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
	
		$this->configName = "PageHeaderPageletConfig";
		parent::__construct($core);
	
	}
	
	/**
	*
	* buildTemplate (Overridden)
	*
	* Rebuilds the template from scratch and returns it.
	*
	* @param string $templateName
	* @param array $templateTokens
	* @return string
	*
	*/
	public function buildTemplate(string $templateName, array $templateTokens=array()) : string
	{
		
		
		$templateTokens['styles'] = '';
		
		foreach ($this->config->data as $style)
			$templateTokens['styles'] .= $style . "\n";
	
		return parent::buildTemplate($templateName, $templateTokens);
	}
	
}