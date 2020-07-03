<?php
namespace phramework;
use phramework;

/**
*
* AutoloadManager
*
* A basic autoloader that recursively scans all directories for class files. This way,
* the developer does not have to add a "include" before a new class is instantiated.
*
* @author Fhiz
* @version 1.0
*
*/
final class AutoloadManager /* extends BaseManager*/
{
	
	/*
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	protected \RecursiveDirectoryIterator $directoryIterator;
	
	public const CLASS_EXTENSION = ".class.php";
	
	public const CONST_DATA 		= "Data";
	public const CONST_CONFIG		= "Config";
	public const CONST_LANGUAGE		= "Languages";
	public const CONST_ENGINE 		= "Engine";
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		spl_autoload_register(array($this, 'loadClass')); 						
	}
	
	/*
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/*
	*
	* loadClass
	*
	* Whenever a class is instantiated using the "new" keyword, the function below is
	* called and recursively searches the Classes directory for a matching file and class.
	*
	* @param string $className
	*
	*/
	private function loadClass(string $className) : void
	{
		
		//TODO: Improve
		//TODO: Include Modules
		
		// ClassName without Namespace
		$className = $this->ExtractClassName($className); 				
		
		// First lets iterate the Config files
		if (!self::includeClass($className, array(self::CONST_DATA, self::CONST_CONFIG)))
		{
			// Now iterate the Class files (if nothing was found previously)
			if (!self::includeClass($className, array(self::CONST_ENGINE)))
			{
			
				// Next iterate the language files if nothing was found
				if (!self::includeClass($className, array(self::CONST_DATA, self::CONST_LANGUAGE)))
				{

					echo "[AutoLoadManager] Class not found: " . $className;
					
				}
			
			}
		
		}
		
	}
	
	/**
	*
	* includeClass
	*
	* @param string $className
	* @param array $directories
	*
	* @return bool
	*
	*/
	private function includeClass(string $className, array $directories) : bool
	{
		
		$directoryPath = self::buildPath(2, "", "", $directories);
		
		$this->directoryIterator = new \RecursiveDirectoryIterator($directoryPath);
		
		foreach (new \RecursiveIteratorIterator($this->directoryIterator) as $file)
		{
			if ($file->getFilename() == $className)
			{
				require_once($file->getPathname());
				return true;
			}
		}
		
		return false;
		
	}
	
	/**
	*
	* ExtractClassName
	*
	* Helper function to get the actual name of a class file including extension but
	* without the namespace.
	*
	* @param string $className
	* @return string
	*
	*/
	private function ExtractClassName(string $className) : string
	{
		if (stristr($className, '\\'))
			return substr($className, strrpos($className, '\\') + 1) . self::CLASS_EXTENSION;
		else
			return $className . self::CLASS_EXTENSION;
	}
	
	/*
	* buildPath
	*
	* @param int $levelsUp
	* @param string $fileName
	* @param string $extension
	* @param array $directories
	* @return string
	*
	*/
	private function buildPath(int $levelsUp, string $fileName, string $extension, array $directories) : string
	{

		$filePath = dirname(__DIR__, $levelsUp);
		
		foreach ($directories as $directory)
			$filePath .= DIRECTORY_SEPARATOR . $directory;
		
		$filePath .= DIRECTORY_SEPARATOR . $fileName . $extension; 	
		
		return $filePath;
		
	}
	
}