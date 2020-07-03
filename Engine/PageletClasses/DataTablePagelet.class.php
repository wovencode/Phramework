<?php
namespace phramework;
use phramework;

/**
*
* DataTablePagelet
*
* @author Fhiz
* @version 1.0
*
*/
abstract class DataTablePagelet extends BasePagelet
{
	
	/*
	* Class Variables
	*/
	protected array $data = array();
	
	/**
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
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
		
		$templateTokens['slots'] = NULL;
		
		/*
		* @parameter NavigationSlot navigationSlot
		*/
		
		foreach ($this->data as $navigationSlot) {
		
			$navigationSlot->initialize($this->core);
				
			$tokens = $navigationSlot->getTemplateTokens();
				
			$templateTokens['slots'] .= $this->core->notifyMediator("TemplateManager", "parseTemplate", $navigationSlot->getTemplate(), $tokens, $this->config::CONST_SLOT);
			
		}
		
		return parent::buildTemplate($templateName, $templateTokens);
		
	}
	
	/**
	*
	* buildTable
	*
	*/
	abstract function buildTable(array $entries, array $data);
	
}