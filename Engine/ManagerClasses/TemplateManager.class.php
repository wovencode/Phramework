<?php
namespace phramework;
use phramework;

/**
*
* TemplateManager
*
* 
*
* @author Fhiz
* @version 1.0
*
*/
final class TemplateManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "TemplateManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		
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
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* getTemplate
	*
	* Retrieves the content of a template file and returns it
	*
	* @param string $templateName
	* @param string $templateDirectory
	* @return string
	*
	*/
	public function getTemplate(string $templateName, string $templateDirectory) : string
	{
	
		$content = "";

		if (!empty($templateName))
		{
		
			$filePath = Tools::buildPath(2, $templateName, $this->config::CONST_EXTENSION, array($this->config::CONST_DATA, $this->config::CONST_DIRECTORY, $templateDirectory));
			
			if (file_exists($filePath))
			{
				$content = trim(file_get_contents($filePath));
			}
			else
			{
				echo "[TemplateManager] cannot load file: " . $filePath . "<br>";
			}
		}
		
		return $content;
		
	}
	
	/**
	*
	* parseTemplate
	*
	* @param string $templateName
	* @param array $templateTokens
	* @param string $templateDirectory
	* @return string
	*
	*/
	public function parseTemplate(string $templateName, array $templateTokens, string $templateDirectory) : string
	{
		
		$content = '';
		
		if (!Tools::mempty($templateName, $templateTokens))
		{
			
			/*
			* Fetch the required template
			*/
			$content = self::getTemplate($templateName, $templateDirectory);
			
			/*
			* Replace all tokens on the template
			*/
			$content = self::replaceTokens($content, $templateTokens);
			
		}
		else
		{
			echo "[TemplateManager] parseTemplate empty.";
		}
		
		return $content;
		
	}
	
	/**
	*
	* replaceTokens
	*
	* Iterates through the provided html markup and replaces all tokens
	*
	* @return string
	*
	*/
	public function replaceTokens(string $content, array $templateTokens) : string
	{
		
		if (!empty($content) && !empty($templateTokens)) {
		
			foreach($templateTokens as $key => $value)
       			$content = str_ireplace("{{$key}}", $value, $content);
			
			$content .= "\n";
		
		}

		return $content;
		
	}
	
	/**
	*
	* renderTemplate
	*
	* Renders a template (or serves it from cache) and sends it to the client
	*
	* @param string $templateName
	* @param array $templateTokens
	* @return void
	*
	*/
	public function renderTemplate(string $templateName, array $templateTokens) : void
	{
		
		if (!Tools::mempty($templateName, $templateTokens)) {
			echo $this->parseTemplate($templateName, $templateTokens);
		} else {
			echo "[TemplateManager] renderTemplate empty.";
		}
		
	}
	
	
}