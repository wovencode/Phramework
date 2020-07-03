<?php
namespace phramework;
use phramework;

/**
*
* Form
*
* @author Fhiz
* @version 1.0
*
*/
class Form
{
	
	protected ?CoreManager $core = NULL;
	protected ?FormManager $parent = NULL;
	
	protected string $formHeader 	= '';
	protected string $formSubmit 	= '';
	protected string $formFooter 	= '';
	protected array $formFields 	= array();
	protected array $checksum 		= array();
	protected bool $autofocus 		= false;
	protected string $formId		= '';
	
	protected const DATA_HEADER 		= '<form action="%s" id="%s" class="%s" method="post" %s>';
	protected const DATA_FIELD_TEXT		= '<input type="%s" name="%s" value="%s" placeholder="%s" class="%s" %s onchange="%s" required validate>';
	protected const DATA_FIELD_CHECKBOX = '<input type="checkbox" name="%s" %s>';
	protected const DATA_FIELD_TEXTAREA = '<textarea placeholder="%s" name="%s" class="%s"></textarea>';
	
	protected const DATA_FIELD_SELECT 	= '<select name="%s" class="%s" onchange="%s" required validate>%s</select>';
	protected const DATA_FIELD_OPTION 	= '<option value="%s" %s>%s</option>';
	protected const DATA_FIELD_RANGE 	= '<input type="range" name="%s" min="%c" max="%c" step="%c" class="%s" required validate>';
	protected const DATA_FIELD_HIDDEN 	= '<input type="hidden" name="%s" value="%s">';
	
	protected const DATA_SUBMIT 		= '<input type="submit" value="%s" class="%s" >';
	protected const DATA_FOOTER 		= '</form>';
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core, FormManager&$parent, string $action, string $class, string $enctype)
	{
		$this->core = $core;
		$this->parent = $parent;
		$this->addFormHeader($action, $class, $enctype);
	}
	
	/*
	* ====================================================================================
	*									PRIVATE
	* ====================================================================================
	*/
	
	/*
	* addFormHeader
	*
	*/
	protected function addFormHeader(string $action, string $class='', string $enctype='')
	{	
		
		$this->formId = $this->core->notifyMediator("CipherManager", "generateToken", 4);
		
		if (!empty($enctype))
			$enctype = 'enctype="'.$enctype.'"';
			
		$this->formHeader = sprintf(self::DATA_HEADER, $action, $this->formId, $class, $enctype);
		
		$this->addFormFooter();
		
	}
	
	/*
	* addFormCSRFField
	*
	*/
	protected function addFormCSRFField()
	{
	
		/*
		* First we generate a new CSRF token
		*/
		$csrf = $this->core->notifyMediator("CipherManager", "generateToken");
		
		/*
		* Next, we notify the SessionManager and add the CSRF token to the session container
		*/
		$this->core->notifyMediator("SessionManager", "setContainer", $this->parent->getNameContainer(), $this->parent->getNameCSRF(), $csrf);
		
		/*
		* Finally we add the hidden input field to the form
		*/
		$this->addInputHidden($this->parent->getNameCSRF(), $csrf, false);
				
	}
	
	/*
	* addFormChecksumField
	*
	*/
	protected function addFormChecksumField()
	{
	
		/*
		* First we generate a new checksum
		*/
		$checksum = $this->core->notifyMediator("CipherManager", "generateChecksumFromArray", $this->checksum);
		
		/*
		* Next, we notify the SessionManager and add the checksum token to the session container
		*/
		#$this->core->notifyMediator("SessionManager", "setContainer", $this->parent->getNameContainer(), $this->parent->getNameChecksum(), $checksum);
		
		/*
		* Finally we add the hidden input field to the form
		*/
		$this->addInputHidden($this->parent->getNameChecksum(), $checksum, false);
		
		$this->checksum = array();
		
	}
	
	/*
	* addFormFooter
	*
	*/
	protected function addFormFooter()
	{
		$this->formFooter = self::DATA_FOOTER;
	}
	
	/*
	* addFormField
	*
	*/
	protected function addFormField(string $name, string $field, string $checksum='')
	{
		$this->formFields[$name] = $field . "\n";
		
		if (!empty($checksum))
			$this->checksum[] = $checksum;
			
	}
	
	/*
	* ====================================================================================
	*									PUBLIC - ADD
	* ====================================================================================
	*/
	
	/*
	* addInputText
	*
	*/
	public function addInputText(string $name, string $type, string $value='', string $placeholder='', string $class='', bool $autoSubmit=false, bool $disabled=false, bool $autofocus=true)
	{
	
		$extraAttributes = '';
		$onChange = '';
		
		if ($autoSubmit == true)
			$onChange = 'this.form.submit();';
		
		if ($autofocus && !$this->autofocus)
		{
			$this->autofocus = true;
			$extraAttributes .= ' autofocus';
		}
		
		if ($disabled)
			$extraAttributes .= ' disabled';
		
		$field = sprintf(self::DATA_FIELD_TEXT, $type, $name, $value, $placeholder, $class, $extraAttributes, $onChange);
		$this->addFormField($name, $field);
	}
	
	/*
	* addInputCheckbox
	*
	*/
	public function addInputCheckbox(string $name, bool $checked=false)
	{
		
		$check = '';
		
		if ($checked)
			$check = ' checked';
			
		$field = sprintf(self::DATA_FIELD_CHECKBOX, $name, $check);
		$this->addFormField($name, $field);
	}
	
	/*
	* addInputSelect
	*
	*/
	public function addInputSelect(string $name, array $options, string $selected='', string $class='', bool $autoSubmit=false)
	{
		
		$fields = "\n";
		
		foreach ($options as $key => $value)
		{
		
			$sel = "";
			
			if ($selected == $key)
				$sel = " selected ";
			
			$fields .= sprintf(self::DATA_FIELD_OPTION, $key, $sel, $value) . "\n";
			
		}
		
		$onChange = "";
		
		if ($autoSubmit == true)
			$onChange = 'this.form.submit();';
		
		$field = sprintf(self::DATA_FIELD_SELECT, $name, $class, $onChange, $fields);
		
		$this->addFormField($name, $field);
	}
	
	/*
	* addInputTextarea
	*
	*/
	public function addInputTextarea(string $name, string $placeholder='', string $class='')
	{
		$field = sprintf(self::DATA_FIELD_TEXTAREA, $name, $class);
		$this->addFormField($name, $field);
	}
	
	/*
	* addInputRangeSlider
	*
	*/
	public function addInputRangeSlider(string $name, int $min, int $max, int $step, string $class='')
	{
		$field = sprintf(self::DATA_FIELD_RANGE, $min, $max, $step, $name, $class);
		$this->addFormField($name, $field, $checksum);
	}
	
	/*
	* addInputHidden
	*
	*/
	public function addInputHidden(string $name, string $value, bool $checksum=true)
	{
		$checksum_string = '';
	
		if ($checksum)
		{
			$name = $this->parent->getPrefixChecksum() . $name;
			$checksum_string = $value;
		}
			
		$field = sprintf(self::DATA_FIELD_HIDDEN, $name, $value);
		
		$this->addFormField($name, $field, $checksum_string);
		
	}
	
	/*
	* addSubmit
	*
	* Use after all FormFields have been added. This completes the form.
	*
	*/
	public function addSubmit(string $value, string $class='')
	{
		$this->addFormCSRFField();
		$this->addFormChecksumField();
		$this->formSubmit = sprintf(self::DATA_SUBMIT, $value, $class);
	}
	
	/*
	* ====================================================================================
	*									PUBLIC - GET 
	* ====================================================================================
	*/
	
	/*
	* getFormHeader
	*
	*/
	public function getFormHeader() : string
	{
		return $this->formHeader;
	}
	
	/*
	* getFormField
	*
	*/
	public function getFormField(string $name) : string
	{
		return $this->formFields[$name];
	}
	
	/*
	* getFormSubmit
	*
	*/
	public function getFormSubmit() : string
	{
		return $this->formSubmit;
	}
	
	/*
	* getFormFooter
	*
	*/
	public function getFormFooter() : string
	{
		$content = "";
		$content .= $this->getFormField($this->parent->getNameCSRF()) . "\n";
		$content .= $this->getFormField($this->parent->getNameChecksum()) . "\n";
		$content .= $this->formFooter;
		return $content;
	}
	
}