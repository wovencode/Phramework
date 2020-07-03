<?php
namespace phramework;
use phramework;

/**
*
* BaseParseable
*
* @author Fhiz
* @version 1.0
*
*/
abstract class BaseParseable
{
	
	/*
	* ====================================================================================
	*                            		HEADER
	* ====================================================================================
	*/
		
	/*
	* Class Variables
	*/
	protected ?CoreManager $core = NULL;
	
	public string $configName = '';
	
	protected ?object $config = NULL;
	protected array $pageletClasses = array();	// array object
	protected array $templateTokens = array();	// array string
	protected string $directoryName = '';
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		self::initializeCore($core);
		self::initializeConfiguration();		
	}
	
	
	/*
	* ====================================================================================
	*                            		PROTECTED
	* ====================================================================================
	*/
	
	/**
	*
	* initializeCore
	*
	*/
	protected function initializeCore(CoreManager&$core=NULL)
	{
		if (!is_null($core))
			$this->core = $core;
	}
	
	/**
	*
	* initializeConfiguration
	*
	*/
	protected function initializeConfiguration()
	{
		if (!empty($this->configName))
		{
		
			$className = __NAMESPACE__ . "\\" . $this->configName;
			
			if (class_exists($className)) {
				$this->config = new $className();
			} else {
				echo "[BaseParseable] Configuration class does not exist: " . $className;
			}
		}
	}
	
	/**
	*
	* initializePagelets
	*
	*/
	protected function initializePagelets()
	{
	
		// Initialize Meta Pagelets
		foreach ($this->config->metaNames as $value)
		{
			$className = __NAMESPACE__ . "\\" . $value;
			$this->pageletClasses[$value] = new $className($this->core);
		}
		
		// Initialize Pagelets
		foreach ($this->config->pageletNames as $value)
		{
			$className = __NAMESPACE__ . "\\" . $value;
			$this->pageletClasses[$value] = new $className($this->core);
		}
		
	}
	
	/*
	* ====================================================================================
	*                            		PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* notifyPagelet
	*
	* 
	*
	*/
	public function notifyPagelet(string $pageletName, string $functionName, ...$params)
	{
	
		foreach ($this->pageletClasses as $key => $pagelet)
		{
			if (strtolower($key) == strtolower($pageletName))
			{
				if (method_exists($pagelet, $functionName))
					call_user_func(array($pagelet, $functionName),...$params);
				
			}
		}
	
	}
	
	/**
	*
	* canDisplay
	*
	* @return bool
	*
	*/
	public function canDisplay() : bool
	{
		return ($this->core->notifyMediator("AccountManager", "checkAccess", 0, $this->config->accessLoggedIn, $this->config->accessLoggedOut, $this->config->accessConfirmed, $this->config->accessUnconfirmed, $this->config->isRiskyAction, $this->config->minAdminLevel));
	}
	
	/**
	*
	* getName
	*
	* @return string
	*
	*/
	public function getName() : string
	{
		/*
		* TODO: Add Language Name here as well
		*/
		return $this->config->templateName;
	}
	
	/**
	*
	* getTemplate
	*
	* @param string $templateName
	* @return string
	*
	*/
	public function getTemplate(string $templateName, array $templateTokens=array()) : string
	{
		
		$content = '';
		
		/*
		* Can this page be cached?
		*/
		if ($this->config->isCached)
		{
		
			/*
			* Does a cached version exist?
			*/
			if ($this->core->notifyMediator("FileCacheManager", "checkFileCache", $templateName, $this->config::CONST_CACHE))
			{
				/*
				* Return the cached version
				*/
				$content = $this->core->notifyMediator("FileCacheManager", "getFileCache", $templateName, $this->config::CONST_CACHE);
			}
			else
			{
				/*
				* First, rebuild the template.
				*/
				$content = static::buildTemplate($templateName, $templateTokens);
				
				/*
				* Second, cache it.
				*/
				$this->core->notifyMediator("FileCacheManager", "setFileCache", $templateName, $content, $this->config::CONST_CACHE);
								
			}
		
		}
		else
		{
			$content = static::buildTemplate($templateName, $templateTokens);
		}
				
		return $content;
	
	}
	
	/**
	*
	* getTemplates
	*
	* @param array $templateTokens
	* @return array
	*
	*/
	public function getTemplates(array $templateTokens=array()) : array
	{
		
		$this->templateTokens = array_merge($this->templateTokens, $templateTokens);
		
		$content = array();
		
		foreach ($this->config->segmentNames as $segment)
		{
			$content[$segment] = $this->getTemplate($segment, $templateTokens);
			$content[$segment] = $this->core->notifyMediator("TemplateManager", "replaceTokens", $content[$segment], $this->templateTokens, $this->directoryName);
		}
		
		/*
		* Finally return the fully assembled template.
		*/
		return $content;
		
	}
	
	/**
	*
	* buildTemplate
	*
	* Assembles the full template from scratch, using the provided name and all avalable tokens
	*
	* @param string $templateName
	* @param array $templateTokens
	* @return string
	*
	*/
	public function buildTemplate(string $templateName, array $templateTokens=array()) : string
	{
		
		$content = '';
		
		/*
		* Argument Tokens (raw-text)
		*
		*/
		if (isset($templateTokens))
		{
			foreach ($templateTokens as $key => $value)
			{
				$this->templateTokens[$key] = $value;
			}
		}
		
		/*
		* Config Language Tokens (raw-text)
		*
		*/
		foreach ($this->config->languageNames as $key => $value)
		{
			$this->templateTokens[$key] = $this->core->notifyMediator("LanguageManager", "getLanguage", $value);
		}
		
		/*
		* Config Tokens (raw-text)
		*
		*/
		foreach ($this->config->tokenNames as $key => $value)
		{
			$this->templateTokens[$key] = $value;
		}
		
		/*
		* Config Temp Cache (raw-text)
		*
		* only uses key, value is provided by cache manager in this case
		*
		*/
		foreach ($this->config->cacheNames as $key)
		{
			$this->templateTokens[$key] = $this->core->notifyMediator("FileCacheManager", "flushTempCache", $key);
		}
		
		/*
		* Pagelets (getTemplate from class)
		*
		*/
		foreach ($this->pageletClasses as $key => $value)
		{
			
			$segments = array();
			$segments = $value->getTemplates($templateTokens);
			
			foreach ($segments as $segment_key => $segment_value)
			{
				$this->templateTokens[$key] = $segment_value;
			}
				
		}
		
		/*
		* Now build the template according to the template tokens provided.
		*/
		$content = $this->core->notifyMediator("TemplateManager", "parseTemplate", $templateName, $this->templateTokens, $this->directoryName);
		
		return $content;
		
	}
		
}