<?php
namespace phramework;
use phramework;

/**
*
* FormManager
*
* Assembles and outputs a html form with integrated checksum and CSRF protection. Can
* only create, maintain and output one form at a time (which is usually enough).
*
* @author Fhiz
*
*/
final class FormManager extends BaseManager
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected ?Form $form = NULL;
	
	/*
	*
	* Constructor (Overridden)
	*
	*/
	public function __construct(CoreManager&$core)
	{
		/*
		* Note: This manager uses InputConfig as well!
		*/
		$this->configName 		= "InputManagerConfig";
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
	* createForm (Wrapper)
	*
	*/
	public function createForm(string $action, string $class='', string $enctype='')
	{
		$this->form = NULL;
		$this->form = new Form($this->core, $this, $action, $class, $enctype);
	}
	
	/**
	*
	* addFormInputText (Wrapper)
	*
	*/
	public function addFormInputText(string $name, string $type, string $value='', string $placeholder='', string $class='', bool $autoSubmit=false, bool $disabled=false, bool $autofocus=true)
	{
		$this->form->addInputText($name, $type, $value, $placeholder, $class, $autoSubmit, $disabled, $autofocus);
	}
	
	/**
	*
	* addFormInputSelect (Wrapper)
	*
	*/
	public function addFormInputSelect(string $name, array $options, string $selected='', string $class='', bool $autoSubmit=false)
	{
		$this->form->addInputSelect($name, $options, $selected, $class, $autoSubmit);
	}
	
	/**
	*
	* addFormInputTextarea (Wrapper)
	*
	*/
	public function addFormInputTextarea(string $name, string $placeholder='', string $class='')
	{
		$this->form->addInputTextarea($name, $placeholder, $class);
	}
	
	/**
	*
	* addFormInputRangeSlider (Wrapper)
	*
	*/
	public function addFormInputRangeSlider(string $name, int $min, int $max, int $step, string $class='')
	{
		$this->form->addInputRangeSlider($name, $min, $max, $step, $class);
	}
	
	/**
	*
	* addFormInputCheckbox (Wrapper)
	*
	*/
	public function addFormInputCheckbox(string $name, bool $checked=false)
	{
		$this->form->addInputCheckbox($name, $checked);
	}
	
	/**
	*
	* addFormInputHidden (Wrapper)
	*
	*/
	public function addFormInputHidden(string $name, string $value)
	{
		$this->form->addInputHidden($name, $value, false);
	}
	
	/**
	*
	* addFormSubmit (Wrapper)
	*
	*/
	public function addFormSubmit(string $value, string $class='')
	{
		$this->form->addSubmit($value, $class);
	}
	
	/**
	*
	* getFormHeader
	*
	* @return string
	*
	*/
	public function getFormHeader() : string
	{
		return $this->form->getFormHeader();
	}
	
	/**
	*
	* getFormField
	*
	* @return string
	*
	*/
	public function getFormField(string $name) : string
	{
		return $this->form->getFormField($name);
	}
	
	/**
	*
	* getFormSubmit
	*
	* @return string
	*
	*/
	public function getFormSubmit() : string
	{
		return $this->form->getFormSubmit();
	}
	
	/**
	*
	* getFormFooter
	*
	* @return string
	*
	*/
	public function getFormFooter() : string
	{
		return $this->form->getFormFooter();
	}
	
	/**
	*
	* getNameContainer (Helper)
	*
	*/
	public function getNameContainer() : string
	{
		return $this->config::CONST_NAME_CONTAINER;
	}
	
	/**
	*
	* getNameChecksum (Helper)
	*
	*/
	public function getNameChecksum() : string
	{
		return $this->config::CONST_NAME_KEY_CHECKSUM;
	}
	
	/**
	*
	* getNameCSRF (Helper)
	*
	*/
	public function getNameCSRF() : string
	{
		return $this->config::CONST_NAME_KEY_CSRF;
	}
	
	/**
	*
	* getPrefixChecksum (Helper)
	*
	*/
	public function getPrefixChecksum() : string
	{
		return $this->config::CONST_PREFIX_CHECKSUM;
	}
	
}