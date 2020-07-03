<?php
namespace phramework;
use phramework;

/**
*
* Session
*
* @author Fhiz
* @version 1.0
*
*/
final class Session
{
	
	private ?CoreManager $core = NULL;
	private $config = NULL;
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		
		$this->core = $core;
		$this->config = new SessionManagerConfig();
		
		self::sessionStart(
							$this->config::CONST_SESSION_PREFIX, 
							$this->config::CONST_SESSION_LIFETIME + time(),
							'/',
							$this->config::CONST_SESSION_DOMAIN,
							$this->config::CONST_SESSION_SECURE,
							$this->config::CONST_SESSION_HTTPONLY
							);
	}
	
	/*
	* ====================================================================================
	*                                       SESSION
	* ====================================================================================
	*/
	
	/**
	*
	* sessionStart
	*
	* This function starts, validates and secures a session.
	*
	* @param string $name The name of the session.
	* @param int $limit Expiration date of the session cookie, 0 for session only
	* @param string $path Used to restrict where the browser sends the cookie
	* @param string $domain Used to allow subdomains access to the cookie
	* @param bool $secure If true the browser only sends the cookie over https
	*
	*/
	public function sessionStart(string $name, $limit = 0, $path = '/', $domain = NULL, $secure = false, $httponly = false)
	{

		if (self::validateSession())
		{
		
			if (!self::preventHijacking())
			{
				$_SESSION = array();
				$_SESSION['IPaddress'] = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
				$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
				self::regenerateSession();
			}
			elseif (Tools::probabilityCheck(5)) // Give a 5% chance of the session id changing on any request
			{
				self::regenerateSession();
			}
			
		}
		else
		{
			self::restartSession($name, $limit, $path, $domain, $secure, $httponly);
		}
		
	}
	
	/**
	*
	* restartSession
	*
	*
	*/
	public function restartSession(string $name, $limit = 0, $path = '/', $domain = NULL, $secure = false, $httponly = false)
	{
		
		if (session_status() == PHP_SESSION_ACTIVE)
			session_destroy();
			
		$_SESSION = array();
		session_name($name . $this->config::CONST_SESSION_SUFFIX);
		$https = isset($secure) ? $secure : isset($_SERVER['HTTPS']);
		session_set_cookie_params($limit, $path, $domain, $https, $httponly);
		session_start();
	}
	
	
	/**
	*
	* regenerateSession
	*
	* This function regenerates a new ID and invalidates the old session.
	* This should be called whenever permission levels for a user change.
	*
	*/
	public function regenerateSession()
	{

		// If this session is obsolete it means there already is a new id

		if (isset($_SESSION['OBSOLETE']) || (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true))
		{
			return;
		}

		// Set current session to expire in 10 seconds

		$_SESSION['OBSOLETE'] = true;
		$_SESSION['EXPIRES'] = time() + 10;

		// Create new session without destroying the old one

		session_regenerate_id(false);

		// Grab current session ID and close both sessions to allow other scripts to use them

		$newSession = session_id();
		session_write_close();

		// Set session ID to the new one, and start it back up again

		session_id($newSession);
		session_start();

		// Now we unset the obsolete and expiration values for the session we want to keep

		unset($_SESSION['OBSOLETE']);
		unset($_SESSION['EXPIRES']);
	}
	
	/**
	*
	* validateSession
	*
	* This function is used to see if a session has expired or not.
	*
	* @return bool
	*
	*/
	protected function validateSession() : bool
	{
		
		if (session_status() == PHP_SESSION_NONE)
			return false;
				
		if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']))
		{
			return false;
		}
		
		if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time())
		{
			return false;
		}
		
		return true;
		
	}
	
	/**
	*
	* preventHijacking
	*
	* This function checks to make sure a session exists and is coming from the proper host.
	* On new visits and hacking attempts this function will return false.
	*
	* @return bool
	*
	*/
	protected function preventHijacking() : bool
	{
	
		if (!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent']))
		{
			return false;
		}
		
		if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'] && !(strpos($_SESSION['userAgent'], 'Trident') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false))
		{
			return false;
		}

		$sessionIpSegment 	= substr($_SESSION['IPaddress'], 0, 7);
		$remoteIpHeader 	= isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		$remoteIpSegment 	= substr($remoteIpHeader, 0, 7);
		
		if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT'])
		{
			return false;
		}
		
		return true;
		
	}
	
	/*
	* ====================================================================================
	*                                       CONTAINERS
	* ====================================================================================
	*/
	
	/**
	*
	* isContainer
	*
	* Checks if a session container of this name exists
	*
	* @return bool
	*
	*/
	public function isContainer($containerName) : bool
	{
		return isset($_SESSION[$containerName]);
	}
	
	/**
	*
	* isKey
	*
	* Checks if a key and its corresponding container of this name exists
	*
	* @return bool
	*
	*/
	public function isKey($keyName, $containerName) : bool
	{
		return isset($_SESSION[$containerName][$keyName]);
	}
	
	/**
	*
	* createContainer
	*
	* Creates a new session container of the given name, if it does not exist yet
	*
	* @return bool
	*
	*/
	public function createContainer($containerName) : bool
	{
		if (!$this->isContainer($containerName))
			$_SESSION[$containerName] = array();
		
		return $this->isContainer($containerName);
	}
	
	/**
	*
	* destroyContainer
	*
	* Destroys a existing session container of the given name
	*
	*/
	public function destroyContainer($containerName) : bool
	{
		if ($this->isContainer($containerName))
			unset($_SESSION[$containerName]);
		
		return !$this->isContainer($containerName);
	}
	
	/**
	*
	* getContainer
	*
	* @return array|null
	*
	*/
	public function getContainer($containerName)
	{
	
		if (!$this->isContainer($containerName))
			return null;
		
		$data = array();
	
		foreach ($_SESSION[$containerName] as $itemName => $itemValue)
		{
			$data[$itemName] = $itemValue;
		}
		
		return $data;
	
	}
	
	/**
	*
	* getContainerValue
	*
	* @return mixed
	*
	*/
	public function getContainerValue($containerName, $keyName)
	{
		$container = $this->getContainer($containerName);
		return $container[$keyName];
	}

	/**
	*
	* getAllContainers
	*
	*
	* @param array names
	*
	* @return array|null
	* 
	*/
	public function getAllContainers($containerNames) : mixed
	{
	
		$results = array();
		
		if (is_array($_SESSION))
		{
		
			foreach ($_SESSION as $containerName => $container)
			{
				if (empty($containerNames) || in_array($containerName, $containerNames))
				{
					$results[] = $this->getContainer($containerName);
				}
			}
		
		}
				
		return !empty($results) ? $results : null;
	
	}

	/**
	*
	* setContainer
	*
	*
	* @param mixed $keyName       	key for identification
    * @param mixed $keyValue     	Value to be stored
    * @param mixed $containerName 	container for grouping
    * @param bool  $overwrite 		Overwrite if exists
    *
    * @return bool true|false
    *
	*/
	public function setContainer($containerName, $keyName, $keyValue, $overwrite=true) : bool
	{
	
		if ($this->isKey($keyName, $containerName) && !$overwrite)
			return false;
		
		if (!$this->createContainer($containerName))
			return false;
		
		$_SESSION[$containerName][$keyName] = $keyValue;
		
		return $this->isKey($keyName, $containerName);
		
	}

	/**
	*
	* destroyAllContainers
	*
	*
	* @param array names
	*
	* @return bool
	*
	*/
	public function destroyAllContainers($containerNames) : bool
	{
		
		$results = array();
		
		if (is_array($_SESSION))
		{
		
			foreach ($_SESSION as $containerName => $container)
			{
				if (empty($containerNames) || in_array($containerName, $containerNames))
				{
					$results[] = $this->destroyContainer($containerName);
				}
			}
		
		}
		else
		{
			return false;
		}
		
		return !in_array(false, $results);
		
	}

}