<?php
namespace phramework;
use phramework;

/**
*
* Tools
*
* A collection of basic utility functions.
*
* @author Fhiz
* @version 1.0
*
*/
class Tools
{
	
	/**
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	
	/** @var array ['suffix' => 'threshold'] */
	private const CONST_NUMBER_THRESHOLDS = [
	'' => 900,
	'K' => 900000,
	'M' => 900000000,
	'B' => 900000000000,
	'T' => 90000000000000,
    ];
	
	/** @var string */
	private const CONST_NUMBER_DEFAULT = '900T+';
	
	protected function __construct() {}
	protected function __clone() {}
	
	/**
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* log
	*
	* @param string $message
	*
	*/
	public static function log(string $msg)
	{  
  		$filename = dirname(__DIR__,2) . DIRECTORY_SEPARATOR . "log.txt";
   		$fd = fopen($filename, "a"); 
   		fwrite($fd, $msg . "\n"); 
   		fclose($fd); 
	} 
	
	/**
	*
	* clamp
	*
	* clamps the given value between min and max
	*
	* @param int $current
	* @param int $min
	* @param int $max
	*
	* @return int
	*
	*/
	public static function clamp(int $current, int $min, int $max) : int
	{
    	return max($min, min($max, $current));
	}

	/**
	*
	* getFullDays
	*
	* @param string $startDate
	* @param string $endDate
	*
	* @return int
	*
	*/
	public static function getFullDays(string $startDate, string $endDate='') : int
	{
		if (empty($endDate))
			$endDate = self::now();
		
    	return (new \DateTime($startDate))->diff(new \DateTime($endDate))->days;
	}
	
	/**
	*
	* getFullMinutes
	*
	* @param string $startDate
	* @param string $endDate
	*
	* @return int
	*
	*/
	public static function getFullMinutes(string $startDate, string $endDate='') : int
	{
		if (empty($endDate))
			$endDate = self::now();
		
    	return (new \DateTime($startDate))->diff(new \DateTime($endDate))->i; // i = minutes
	}
	
	/**
	*
	* getFullTicks
	*
	* 
	*
	* @param string $start
	* @param int $duration
	*
	* @return bool
	*
	*/
	public static function getFullTicks(string $start, int $duration, int $tickLength=1) : bool
	{
		$time = 0;
		
		if (!self::mempty($start, $duration)) {
			if (self::checkDuration($start, $duration, $tickLength)) {

				$start 	= strtotime($start);
				$end 	= time();
				$time 	= floor(($end - $start) / ($duration * $tickLength));
				
			}
		}
		
		return $time;
	}

	/**
	*
	* checkDuration
	*
	* checks if the given <duration> has passed since <start>
	*
	* @param string $start
	* @param int $duration
	*
	* @return bool
	*
	*/
	public static function checkDuration(string $start, int $duration, int $tickLength=1) : bool
	{
		if (!self::mempty($start, $duration)) {
			$start = strtotime($start) + ($duration * $tickLength);
			$end = time();
			
			return ($end >= $start);
			
		}
		return false;
	}
		
	/**
	*
	* mempty
	*
	* Checks multiple arguments for empty()
	*
	* @param mixed $arguments
	*
	* @return bool
	*
	*/
	public static function mempty() : bool
	{
		foreach (func_get_args() as $arg)
			if (empty($arg))
				continue;
			else
				return false;
		return true;
	}
	
	/**
	*
	* mtrue
	*
	* Checks multiple boolean arguments for true
	*
	* @param bool $arguments
	*
	* @return bool
	*
	*/
	public static function mtrue() : bool
	{
		foreach (func_get_args() as $arg)
			if (is_bool($arg) && $arg == TRUE)
				continue;
			else
				return false;
		return true;
	}
	
	/**
	*
	* startsWith
	*
	* @param string $string (the string it starts with)
	* @param string $startString (the string to search)
	* @return bool
	*
	*/
	public static function startsWith ($string, $startString) : bool
	{ 
    	$len = strlen($startString); 
    	return (substr($string, 0, $len) === $startString); 
	}

	/**
	*
	* endsWith
	*
	* @param string $string (the string it ends with)
	* @param string $startString (the string to search)
	* @return bool
	*
	*/
	public static function endsWith($string, $endString)  : bool
	{ 
    	$len = strlen($endString); 
    	if ($len == 0) { 
    	    return true; 
    	} 
    	return (substr($string, -$len) === $endString); 
	} 
	
	/**
	*
	* now
	*
	* @return string
	*
	*/
	public static function now() : string
	{
		return date("Y-m-d H:i:s");
	}
	
	/**
	*
	* now
	*
	* @return string
	*
	*/
	public static function maskString(string $string, string $mask="*", int $maxLength=8) : string
	{
		return str_repeat($mask, min(strlen($string), $maxLength));
	}
	
	/**
	*
	* substr_in_array
	*
	* @param string $string
	* @param array $startString
	* @param bool $caseSensitive
	* @return bool
	*
	*/
	public static function substr_in_array(string $str, array $array, bool $caseSensitive = FALSE) : bool
	{
	
  		if ($caseSensitive) {
    		foreach ($array as $value)
    			if (strpos($str, $value) !== FALSE)
    				return TRUE;
  		} else {
    		foreach ($array as $value)
    			if (stripos($str, $value) !== FALSE)
    				return TRUE;
  		}
  		
  		return FALSE;
  	
	}
	
	/**
	*
	* ProbabilityCheck
	*
	* Performs a simple, %-based probability check
	*
	* @return bool
	*
	*/
	public static function ProbabilityCheck($probability=100, $min=1, $max=100) : bool
	{
		return (rand($min, $max) <= $probability);
	}
	
	/*
	*
	* getMobileClient
	*
	* @return bool
	*
	*/
	public static function getMobileClient() : bool
	{
		return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($_SERVER['HTTP_USER_AGENT'], 0, 4)));
	}
	
	/*
	*
	* getClientAddress
	*
	* @return string
	*
	*/
	public static function getClientAddress(): string
	{
		$ip = '';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    		$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
    		$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/*
	*
	* getClientAgent
	*
	* @return string
	*
	*/
	public static function getClientAgent(): string
	{
		return $_SERVER['HTTP_USER_AGENT'];
	}
	
	
	/*
	*
	* getClientAgent
	*
	* @return string
	*
	*/
	public static function countArrayDimensions($Array, $count = 0)
	{
   		if (is_array($Array)) {
    		return self::countArrayDimensions(current($Array), ++$count);
   		} else {
    		return $count;
   		}
	}
	
	/*
	* buildPath
	*
	* Builds a path to be used by includes and requires.
	*
	* @param int $levelsUp
	* @param string $fileName
	* @param string $extension
	* @param array $directories
	* @return string
	*
	*/
	public static function buildPath(int $levelsUp, string $fileName, string $extension='', array $directories=array()) : string
	{

		$filePath = dirname(__DIR__, $levelsUp);
		
		foreach ($directories as $directory)
			$filePath .= DIRECTORY_SEPARATOR . $directory;
		
		$filePath .= DIRECTORY_SEPARATOR . $fileName . $extension; 	
		
		return $filePath;
		
	}
	
	/*
	* buildPublicPath
	*
	* Builds a path to be used in public, for example to link images and script files
	*
	* @param string $root
	* @param string $fileName
	* @param array $directories
	* @return string
	*
	*/
	public static function buildPublicPath(string $root, string $fileName, array $directories) : string
	{
		
		if (empty($root))
			$filePath = ".";
		else
			$filePath = $root;
		
		foreach ($directories as $directory)
			$filePath .= DIRECTORY_SEPARATOR . $directory;
		
		$filePath .= DIRECTORY_SEPARATOR . $fileName; 	
		
		return $filePath;
		
	}
	
	/*
	* validateString
	*
	*/
	public static function sanitizeString(string $string) : string
	{
		return filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	}
	
	/*
	* validateInteger
	*
	*/
	public static function validateInteger($int, int $min=-1, int $max=-1) : bool
	{
		
		if ($min == -1)
			$min = PHP_INT_MIN;
		
		if ($max == -1)
			$max = PHP_INT_MAX;
		
		return (filter_var($int, FILTER_VALIDATE_INT) === 0 || !filter_var($int, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === false);
	}
	
	/*
	* validateName
	*
	*/
	public static function validateName(string $name, int $minLength=4, int $maxLength=16) : bool
	{
		return ctype_alnum($name) && 
			strlen($name) >= $minLength &&
			strlen($name) <= $maxLength
			;
	}
	
	/*
	* validatePassword
	*
	*/
	public static function validatePassword(string $password, bool $uppercase=false, bool $lowercase=false, bool $number=false, bool $special=false, int $minLength=4, int $maxLength=16) : bool
	{
		
		return
			(
			(!$uppercase || $uppercase && preg_match('@[A-Z]@', $password)) &&
			(!$lowercase || $lowercase && preg_match('@[a-z]@', $password)) &&
			(!$number || $number && preg_match('@[0-9]@', $password)) &&
			(!$special || $special && preg_match('@[^\w]@', $password)) &&
			(strlen($password) >= $minLength) &&
			(strlen($password) <= $maxLength)
			);
	}
	
	/*
	* validateEmail
	*
	*/
	public static function validateEmail($email) : bool
	{
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false);
	}
	
	/*
	* validateUrl
	*
	*/
	public static function validateUrl($url) : bool
	{
		$url = filter_var($url, FILTER_SANITIZE_URL);
		return (!filter_var($url, FILTER_VALIDATE_URL) === false);
	}
	
	/*
	* validateIp
	*
	* Works with IPV4 and IPV6
	*/
	public static function validateIp($ip) : bool
	{
		
		if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
			return true;
		} else if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
			return true;
		}
		
		return false;
		
	}
	
	/*
	* redirect
	*
	* Savely redirect the client to another page (by using "die" afterwards to stop script execution)
	*
	* @param string
	*
	*/
	public static function redirect(string $url)
	{
		header("Location: " . $url);
		die();
	}
	
	/**
	*
	* readableNumber
	*
    * @param float $value
    * @param int $precision
    * @return string
    */
	public static function readableNumber(float $value, int $precision = 1): string
    {
    
		foreach (self::CONST_NUMBER_THRESHOLDS as $suffix => $threshold) {
			if ($value < $threshold) {
				return self::format($value, $precision, $threshold, $suffix);
            }
        }
        
		return self::CONST_NUMBER_DEFAULT;
		
    }
	
	/**
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
    *
    * formatNumber
    *
    * @param float $value
    * @param int $precision
    * @param int $threshold
    * @param string $suffix
    * @return string
    */
	private static  function formatNumber(float $value, int $precision, int $threshold, string $suffix): string
    {
		$formattedNumber = number_format($value / ($threshold / self::THRESHOLDS['']), $precision);
		$cleanedNumber = (strpos($formattedNumber, '.') === false)
            ? $formattedNumber
            : rtrim(rtrim($formattedNumber, '0'), '.');
		return $cleanedNumber . $suffix;
    }
	
}