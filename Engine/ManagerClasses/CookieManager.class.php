<?php
namespace phramework;
use phramework;

/**
*
* CookieManager
*
* 
*
* @author Fhiz
* @version 1.0
*
*/
final class CookieManager extends BaseManager
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
		$this->configName 		= "CookieManagerConfig";
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
	
	/**
	*
	* writeCookie
	*
	* Writes the string $value to the cookie, using provided configuration settings
	*
	* @param array $data
	* @return bool
	*
	*/
	protected function writeCookie(string $value) : bool
	{
		
		setcookie(
				$this->config::CONST_COOKIE_NAME,
				$value,
				time() + $this->config::CONST_COOKIE_EXPIRES,
				$this->config::CONST_COOKIE_PATH,
				$this->config::CONST_COOKIE_DOMAIN,
				$this->config::CONST_COOKIE_SECURE,
				$this->config::CONST_COOKIE_HTTPONLY
				);
	
		return $this->hasCookie();
		
	}
	
	/**
	*
	* hasCookie
	*
	*/
	public function hasCookie() : bool
	{
		return isset($_COOKIE[$this->config::CONST_COOKIE_NAME]);
	}
	
	/**
	*
	* saveToCookie
	*
	* @param array $data
	* @return bool
	*
	*/
	public function saveToCookie(array $data) : bool
	{
		
		if (empty($data))
			return false;
		
		/*
		*
		*/
		foreach ($data as $key => $value) {
			$data[$key] = $this->core->notifyMediator("CipherManager", "encrypt", htmlspecialchars($value));
		}
		
		/*
		*
		*/
		if ($this->config::CONST_COOKIE_CHECKSUM) {
			$data[$this->config::CONST_COOKIE_NAME."_cs"] = $this->core->notifyMediator("CipherManager", "generateChecksumFromArray", $data);
		}
		
		return self::writeCookie(json_encode($data));
		
	}
	
	/**
	*
	* loadFromCookie
	*
	* @return array
	*
	*/
	public function loadFromCookie()
	{
	
		$data_decoded = null;
		
		if ($this->hasCookie()) {
		
			$data = array();
			
			$data = json_decode($_COOKIE[$this->config::CONST_COOKIE_NAME], true);
			
			/*
			*
			*/
			if ($this->config::CONST_COOKIE_CHECKSUM) {
				
				$checksum_cookie = $data[$this->config::CONST_COOKIE_NAME."_cs"];
				unset($data[$this->config::CONST_COOKIE_NAME."_cs"]);
				
				$checksum = $this->core->notifyMediator("CipherManager", "generateChecksumFromArray", $data);
				
				if ($checksum != $checksum_cookie)
				{
					$data = null;
					echo "[CookieManager] Checksum failed.";
				}
			}
			
			/*
			*
			*/
			$data_decoded = array();
			
			foreach ($data as $key => $value) {
				$data_decoded[$key] = htmlspecialchars_decode($this->core->notifyMediator("CipherManager", "decrypt", $value));
			}
			
		}
		
		return $data_decoded;
	
	}
	
	/**
	*
	* updateCookie
	*
	* Updates the data stored inside the cookie with the one of the stated accountId. This
	* function is required for RememberMe/AutoLogin
	*
	* @return bool
	*
	*/
	public function updateCookie(int $accountId) : bool
	{
	
		if ($this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'rememberMe') == true) {
			
			$data 					= array();
			$data['uniqueId'] 			= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'uniqueId');
			$data['loginToken'] 	= $this->core->notifyMediator("AccountManager", "getAccountDatabaseData", $accountId, 'loginToken');
			
			return $this->saveToCookie($data);
			
		}
		
		return $this->resetCookie($accountId);
				
	}
	
	/**
	*
	* resetCookie
	*
	* @return bool
	*
	*/
	public function resetCookie(int $accountId) : bool
	{
	
		if ($this->hasCookie()) {
			$ok = $this->writeCookie('');
			$this->core->dispatchEvent('onCookieReset', $accountId);
			return $ok;
		}
		
		return false;
			
	}
	
}