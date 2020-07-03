<?php
namespace phramework;
use phramework;

/**
*
* WelcomeScreenConfig
*
* @author Fhiz
* @version 1.0
*
*/
class WelcomeScreenPageletConfig extends BasePageletConfig
{

	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->templateName = "WelcomeScreenPagelet";
		
		/*
		* Languages
		*/
		$this->languageNames['LangGameTitle'] 		= 'gameTitle';
		$this->languageNames['LangSubTitle']		= 'subTitle';
		$this->languageNames['LangPressToStart'] 	= 'pressToStart';
		$this->languageNames['LangCopyrightNotice'] = 'copyrightNotice';
		
		parent::__construct();
	}
	
}