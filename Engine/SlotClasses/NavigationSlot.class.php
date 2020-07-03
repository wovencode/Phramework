<?php
namespace phramework;
use phramework;

/**
*
* NavigationSlot
*
* @author Fhiz
* @version 1.0
*
*/
class NavigationSlot extends BaseConfig
{

	/*
	* Class Variables
	*/
	protected array $data = array();
	
	protected ?CoreManager $core;		// CoreManager (reference to the engine)
	protected string $labelText;		// string (the actual language specific text to be displayed)
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct(array $data)
	{
		$this->parseData($data);
	}
	
	/**
	*
	* initializeData
	*
	*/
	protected function initializeData()
	{
		
		$this->data['tokenName'] 		= '';		// string
		$this->data['templateName'] 	= '';		// string
		$this->data['labelName'] 		= '';		// string
		
		$this->data['linkTarget'] 		= '';		// string
		$this->data['linkClass'] 		= '';		// string
		
		$this->data['iconName'] 		= '';		// string
		$this->data['iconClass'] 		= '';		// string
		$this->data['iconSize'] 		= '28';		// string
		$this->data['iconColor'] 		= 'white';	// string
		$this->data['color'] 			= '';
		
		$this->data['isLoggedIn'] 		= true;		// bool
		$this->data['isLoggedOut'] 		= true;		// bool
		$this->data['isConfirmed'] 		= true;		// bool
		$this->data['accessUnconfirmed']	= true;		// bool
		$this->data['isRiskyAction']	= false;	// bool
		$this->data['minAdminLevel'] 	= 0;		// int
		
		$this->data['disabled'] 	= '';		// string
		
		/*
		*
		* color
		*
		*/
		$this->data['disabledColor'] 	= 'gray';		// string
		
		/*
		*
		* string
		*
		* ImageIcon.slot
		* F7Icon.slot
		* RPGAwesomeIcon.slot
		* FontAwesomeIcon.slot
		*
		*/
		$this->data['slotPrefabName'] 	= 'ImageIcon.slot';		// string (slot prefab for icons)
		
	}
	
	/**
	*
	* parseData
	*
	*/
	protected function parseData(array $data)
	{
	
		$this->initializeData();
		
		foreach ($data as $key => $value)
		{
			$this->data[$key] = $value;
		}
		
	}
	
	/*
	*
	* initialize
	*
	*/
	public function initialize(CoreManager&$core)
	{
		$this->core = $core;
		
		$this->setLabel();
		
	}
	
	/*
	*
	* toggleDisabled
	*
	*/
	public function toggleDisabled()
	{
		if (empty($this->data['disabled']))
		{
			$this->data['disabled'] = 'disabled';
		} else {
			$this->data['disabled'] = '';
		}
	}
	
	/*
	*
	* setLabel
	*
	* sets the label text to a translated language text or parses the label as raw if nothing found
	*
	*/
	public function setLabel()
	{
		
		$text = $this->data['labelName'];
		
		if ($this->core->notifyMediator("LanguageManager", "getLanguageKey", $this->data['labelName'] ))
			$text = $this->core->notifyMediator("LanguageManager", "getLanguage", $this->data['labelName']);
		
		$this->labelText = $text;
	}
	
	/*
	*
	* getLoggedIn
	*
	* @return bool
	*
	*/
	public function getLoggedIn() : bool
	{
		return $this->data['isLoggedIn'];
	}
	
	/*
	*
	* getLoggedOut
	*
	* @return bool
	*
	*/
	public function getLoggedOut() : bool
	{
		return $this->data['isLoggedOut'];
	}
	
	/*
	*
	* getConfirmed
	*
	* @return bool
	*
	*/
	public function getConfirmed() : bool
	{
		return $this->data['isConfirmed'];
	}
	
	/*
	*
	* getUnconfirmed
	*
	* @return bool
	*
	*/
	public function getUnconfirmed() : bool
	{
		return $this->data['accessUnconfirmed'];
	}
	
	/*
	*
	* getRiskyAction
	*
	* @return bool
	*
	*/
	public function getRiskyAction() : bool
	{
		return $this->data['isRiskyAction'];
	}
	
	/*
	*
	* getMinAdminLevel
	*
	* @return bool
	*
	*/
	public function getMinAdminLevel() : int
	{
		return $this->data['minAdminLevel'];
	}
	
	/*
	*
	* getTemplate
	*
	* @return string
	*
	*/
	public function getTemplate() : string
	{
		return $this->data['templateName'];
	}
	
	/*
	*
	* getToken
	*
	* @return string
	*
	*/
	public function getToken() : string
	{
		return $this->data['tokenName'];
	}
	
	/*
	*
	* getButtonColor
	*
	* @return string
	*
	*/
	public function getButtonColor()
	{
		if (empty($this->data['disabled']))
			return $this->data['color'];
		else
			return $this->data['disabledColor'];
	}
	
	/*
	*
	* getLink
	*
	* @return string
	*
	*/
	public function getLink()
	{
		return $this->core->notifyMediator("RouterManager", "getRouteLink", $this->data['linkTarget'], false);
	}
	
	/*
	*
	* getIcon
	*
	* @return string
	*
	*/
	public function getIcon()
	{
		$content = "";
		
		if (!empty($this->data['iconName']))
		{
			$templateParameters = array();
			
			/*
			* Image Icons
			*/
			$templateParameters['class'] 	= $this->data['iconClass'];
			$templateParameters['link'] 	= Tools::buildPublicPath(self::CONST_CDN_MEDIA, $this->data['iconName'], array(self::CONST_PUBLIC, self::CONST_MEDIA, self::CONST_ICONS));
			
			/*
			* Font Icons
			*/
			$templateParameters['size'] 	= $this->data['iconSize'];
			$templateParameters['color'] 	= $this->data['iconColor'];
			$templateParameters['icon'] 	= $this->data['iconName'];
			
			$content = $this->core->notifyMediator("TemplateManager", "parseTemplate", $this->data['slotPrefabName'], $templateParameters, self::CONST_SLOT);
		}
		
		return $content;
	}
	
	/*
	*
	* getTemplateTokens
	*
	* @return array
	*
	*/
	public function getTemplateTokens(array $templateTokens=array()) : array
	{
		
		$templateTokens['label'] 	= $this->labelText;
		$templateTokens['link'] 	= $this->getLink();
		$templateTokens['class'] 	= $this->data['linkClass'];
		$templateTokens['icon'] 	= $this->getIcon();
		$templateTokens['disabled'] = $this->data['disabled'];
		$templateTokens['color'] 	= $this->getButtonColor();
		
		return $templateTokens;
		
	}
	
	
}