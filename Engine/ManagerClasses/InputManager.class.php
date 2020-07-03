<?php
namespace phramework;
use phramework;

/**
*
* InputManager
*
* This simple class sanitizes the input provided by the client. It only allows strings or
* integers and the integers have a min and max range.
*
* @author Fhiz
* @version 1.0
*
*/
final class InputManager extends BaseManager
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
		$this->validatePostChecksum();
		$this->validatePostCSRF();
		$this->sanitizeVariables($_POST);
		$this->sanitizeVariables($_GET);
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
	* getMaxFileSize
	*
	* @return int
	*
	*/
	public function getMaxFileSize() : int
	{
		return $this->config::CONST_FILESIZE_MAX;	
	}
	
	/**
	*
	* validateUploads
	*
	* @return bool
	*
	*/
	public function validateUpload(string $name) : string
	{
		
		if (empty($name))
			return '';
			
		// Check size to validate if its a real IMAGE
		$size = getimagesize($_FILES[$name]['tmp_name']);
		if (!$size)
			return '';
		
		// Create Fileinfo and Extension
		$finfo = new \finfo(FILEINFO_MIME_TYPE);
		$fileExtension = \pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
		
		// Check MIME type manually
		if (false === $fileExtension = array_search($finfo->file($_FILES[$name]['tmp_name']), $this->config::CONST_FILETYPES_IMAGE, true))
			return '';
			
		// Create a unique name (never use the filename)
		$fileName = sha1_file($_FILES[$name]['tmp_name']) . "." . $fileExtension;
		
		// Build path to save the file on the server
		$filePath = Tools::buildPublicPath($this->config->getUploadCDN('.'), $fileName, array($this->config::CONST_PUBLIC, $this->config::CONST_MEDIA, $this->config::CONST_AVATARS));
		
		// Undefined | Multiple Files | $_FILES Corruption Attack
		if (!isset($_FILES[$name]['error']) || is_array($_FILES[$name]['error']))
			return '';
		
		// Filesize
		if ($_FILES[$name]['size'] <= 0 || $_FILES[$name]['size'] > $this->config::CONST_FILESIZE_MAX)
			return '';
				
		// Move the uploaded file
		if (!move_uploaded_file($_FILES[$name]['tmp_name'], $filePath))
			return '';
		
		return $fileName;
		
	}
	
	/**
	*
	* validateUploads
	*
	* @return bool
	*
	*/
	public function uploadExists() : bool
	{
	
	
	}
	
	
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
	*
	* validatePostChecksum
	*
	*/
	protected function validatePostChecksum()
	{
	
	
		if (isset($_POST[$this->config::CONST_NAME_KEY_CHECKSUM])) {
			
			$checksum = '';
			$checksum_array = array();
			$new_key= '';
			
			foreach ($_POST as $key => $value)
			{
				
				if ($key == $this->config::CONST_NAME_KEY_CHECKSUM)
					continue;
					
				if (Tools::startsWith($this->config::CONST_PREFIX_CHECKSUM, $key))
				{
					$checksum_array[] = $value;
					$new_key = ltrim($key, $this->config::CONST_PREFIX_CHECKSUM);
					unset($_POST[$key]);
					$_POST[$new_key] = $value;					
				}
				
			}
			
			$checksum = $this->core->notifyMediator("CipherManager", "generateChecksumFromArray", $checksum_array);
			
			#$checksum = $this->core->notifyMediator("SessionManager", "getContainerValue", $this->config::CONST_NAME_CONTAINER, $this->config::CONST_NAME_KEY_CHECKSUM);
			
			if (!hash_equals($_POST[$this->config::CONST_NAME_KEY_CHECKSUM], $checksum))
				die("Checksum failed.");

		}
	}
	
	/**
	*
	* validatePostCSRF
	*
	*/
	protected function validatePostCSRF()
	{
		if (isset($_POST[$this->config::CONST_NAME_KEY_CSRF])) {
			
			$csrf = $this->core->notifyMediator("SessionManager", "getContainerValue", $this->config::CONST_NAME_CONTAINER, $this->config::CONST_NAME_KEY_CSRF);
			
			if (!hash_equals($_POST[$this->config::CONST_NAME_KEY_CSRF], $csrf))
				die("CSRF failed.");
				
		}
	}
	
	/**
	*
	* sanitizeVariables
	*
	*/
	protected function sanitizeVariables(&$variables)
	{
	
		foreach ($variables as $key => $value)
		{
    		if (is_string($value))
    		{
    			$variables[$key] = Tools::sanitizeString($variables[$key]);
    		}
    		else if (is_int($value))
    		{
    			if (!Tools::validateInteger($_POST[$key], $this->config::CONST_INTEGER_MIN ,$this->config::CONST_INTEGER_MAX))
        		{
        			$variables[$key] = NULL;
        		}
    		}
    		else
    		{
    			$variables[$key] = NULL;
    		}
		
		}
	}
	
	
}