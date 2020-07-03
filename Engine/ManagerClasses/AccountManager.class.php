<?php
namespace phramework;
use phramework;

/**
*
* AccountManager
*
* @author Fhiz
* @version 1.0
*
*/
final class AccountManager extends BaseManager
{
	
	/**
	* ====================================================================================
	*                                       HEADER
	* ====================================================================================
	*/
	
	/*
	* Class Variables
	*/
	protected array $accounts = array();
	
	/**
	*
	* Constructor
	*
	*/
	public function __construct(CoreManager&$core)
	{
		$this->configName = "AccountManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize
	*
	*/
	protected function initialize()
	{
	
	}
	
	/**
	*
	* initializeLate (Overridden)
	*
	* Tries to load the MAIN (ID0) account either by using the provided SESSION or
	* COOKIE data.
	*
	* @return void
	* 
	*/
	public function initializeLate() : void
	{
		
		$data = null;
		
		/*
		* First, try to load the account from the active SESSION
		*/
		
		$data = $this->core->notifyMediator("SessionManager", "getContainer", "Account");
		
		if (!is_null($data) && !empty($data)) {
			if ($this->loadAccount(0, $data));
				return;
		}
		
		/*
		* If that fails, try to load the account from the COOKIE instead
		*/
		
		if (is_null($data)) {
		
			$data = $this->core->notifyMediator("CookieManager", "loadFromCookie");
			
			if (!is_null($data) && !empty($data)) {
				$this->loadAccount(0, $data);
			}
		}
	}
	
	/**
	* ====================================================================================
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/**
	*
	* verifyAccount
	*
	* Checks if an account of the stated ID exists and is valid
	*
	* @param int $accountId
	* @param string $name
	* @param string $password
	* @return bool 
	*
	*/
	private function verifyAccount(int $accountId, string $name, string $password) : bool
	{
		return ($this->accounts[$accountId] != NULL && $this->accounts[$accountId]->verifyAccount($name, $password));
	}
	
	/**
	*
	* loadAccount
	*
	* loads the account of the stated Id, using the provided data. loading always refreshes the in-memory data
	* this loading process requires at least the name of the account to be in the $data array
	*
	* @param int $accountId
	* @param array $data
	* @return bool 
	*
	*/
	private function loadAccount(int $accountId, array $data) : bool
	{
		
		$databaseData = array();
		
		if (!isset($data['name']) && !isset($data['uniqueId']))
			return false;
			
		/*
		* Reload from Database
		* either by uniqueId (preferred)
		* or by name
		*/
		if (isset($data['uniqueId']))
			$databaseData = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, 'SELECT * FROM `account` WHERE `uniqueId`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $data['uniqueId']);
		else
			$databaseData = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, 'SELECT * FROM `account` WHERE `name`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $data['name']);
		
		/*
		* Account does not exist, is banned etc.
		*/
		if ($databaseData == false || count($databaseData) <= 0)
			return false;
		
		/*
		* Check Password
		*/
		if (!isset($data['password']) || $this->core->notifyMediator("CipherManager", "verifyPassword", $data['password'], $databaseData['passwordHash']) == false) {
		
			/*
			* Now try by checking Login Token
			*/
			if (!isset($data['loginToken']) || $data['loginToken'] != $databaseData['loginToken'])
				return false;
				
		}
		
		/*
		* Prepare account & additional data
		*/
		$databaseData['lastonline'] = Tools::now();					// updated every time
		$databaseData['agent'] 		= Tools::getClientAgent(); 		// updated every time
		$databaseData['ip'] 		= Tools::getClientAddress(); 	// updated every time
		
		if (isset($data['rememberMe']))								// updated every time
			$databaseData['rememberMe'] = $data['rememberMe'];		
		
		$this->accounts[$accountId] = new Account($this->core);
		$this->accounts[$accountId]->parseTemporaryData($data);
		$this->accounts[$accountId]->parseDatabaseData($databaseData);

		/*
		* Trigger Event
		*/
		$this->core->dispatchEvent('onAccountLoaded', $accountId);
		
		return true;
		
	}
	
	/**
	*
	* requestSecurityTokenAndEmail
	*
	* 
	*
	* @param int $accountId
	* @param string $mailTemplate
	* @return bool 
	*
	*/
	private function requestSecurityTokenAndEmail(int $accountId, string $mailTemplate) : bool
	{
	
		if (!$this->checkRiskyAction($accountId))
			return false;
			
		$token = $this->core->notifyMediator("CipherManager", "generateToken");
		
		$email = $this->getAccountDatabaseData($accountId, 'email');
		
		$this->setAccountDatabaseData($accountId, 'securityToken', 		$token, 		false); 	// no save
		$this->setAccountDatabaseData($accountId, 'lasttoken', 			Tools::now(), 	false);		// no save
		$this->setAccountDatabaseData($accountId, 'lastriskyaction', 	Tools::now()); 				// now do save
		
		return $this->core->notifyMediator("MailManager", $mailTemplate, $email, $token);
		
	}
	
	/**
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/**
	* 
	* validateUsername (Helper)
	* 
	* Helper function to validate an account name using common rules and profanity check
	*
	* @param string
	* @return bool 
	*
	*/
	public function validateUsername(string $name) : bool
	{
		return Tools::validateName($name, $this->config::CONST_MINLENGTH_ACCOUNT, $this->config::CONST_MAXLENGTH_ACCOUNT) &&
				!$this->core->notifyMediator("LanguageManager", "checkProfanity", $name);
	}
	
	/**
	* 
	* validateEmail (Helper)
	* 
	* Helper function to validate an account email using common rules
	*
	* @param string
	* @return bool 
	*
	*/
	public function validateEmail(string $email) : bool
	{
		return Tools::validateEmail($email);
	}
	
	/**
	* 
	* validatePassword (Helper)
	* 
	* Helper function to validate an account password using common rules
	*
	* @param string
	* @return bool 
	*
	*/
	public function validatePassword(string $password) : bool
	{
	
		return Tools::validatePassword($password,
										$this->config::CONST_PASSWORD_UPPERCASE,
										$this->config::CONST_PASSWORD_LOWERCASE,
										$this->config::CONST_PASSWORD_NUMERIC,
										$this->config::CONST_PASSWORD_SPECIALCHAR,
										$this->config::CONST_MINLENGTH_PASSWORD,
										$this->config::CONST_MAXLENGTH_PASSWORD
										);
	
	}
	
	/**
	* 
	* checkRiskyAction
	* 
	* Helper function to check if another risky action can be performed right now
	* Returns TRUE if another risky action can be performed, otherwise FALSE
	*
	* @return bool 
	*
	*/
	public function checkRiskyAction(int $accountId) : bool
	{
		return (Tools::getFullMinutes($this->getAccountDatabaseData($accountId, 'lastriskyaction')) >= $this->config::CONST_RISKY_ACTION_DELAY);
	}
	
	/**
	* 
	* checkTokenStillValid
	* 
	* Helper function to check if the security token is still valid
	*
	* @return bool 
	*
	*/
	public function checkTokenStillValid(int $accountId) : bool
	{
		return (Tools::getFullMinutes($this->getAccountDatabaseData($accountId, 'lasttoken')) <= $this->config::CONST_TOKEN_EXPIRATION);
	}
	
	/**
	* 
	* checkValid
	* 
	* Checks if the account is valid (according to account data).
	* For the main account, this means the account is logged in as well.
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function checkAccountValid(int $accountId) : bool
	{
		return (isset($this->accounts[$accountId]) && 
				$this->accounts[$accountId] != NULL &&
				$this->accounts[$accountId]->isValid());
	}
	
	/**
	*
	* checkAccess
	*
	* Checks if access is allowed, based on the status of the user
	*
	* @param int $accountId
	* @param bool $loggedIn
	* @param bool $loggedOut
	* @param bool $confirmed
	* @param bool $unconfirmed
	* @param int $minAdminLevel
	* @param bool $riskyAction
	* @return bool
	*
	*/
	public function checkAccess(int $accountId, bool $loggedIn, bool $loggedOut, bool $confirmed, bool $unconfirmed, bool $riskyAction, int $minAdminLevel) : bool
	{
		
		$confirmedStatus 	= false;
		$adminLevel 		= 0;
		$validAccount 		= $this->checkAccountValid($accountId);
		
		if ($validAccount) {
			
			// Check Confirmed Status
			$confirmedStatus = $this->accounts[$accountId]->getDatabaseData('confirmed');
			
			if (
				($confirmedStatus && !$confirmed) ||
				(!$confirmedStatus && !$unconfirmed)
				)
					return false;
			
			// Check Admin Level
			if ($minAdminLevel > 0) {
				if ($this->accounts[$accountId]->getDatabaseData('admin') < $minAdminLevel)
					return false;
			}
			
			// Check Risky Action
			if ($riskyAction && !$this->checkRiskyAction($accountId))
				return false;
				
		}
		
		return (
				($validAccount && $loggedIn) || 
				(!$validAccount && $loggedOut)
				);
		
	}
	
	/**
	*
	* saveAccount
	*
	* Saves the account if its valid and it data changed since last save
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function saveAccount(int $accountId) : bool
	{
	
		if (!$this->checkAccountValid($accountId) || !$this->accounts[$accountId]->hasChanged())
			return false;
		
		$this->setAccountDatabaseData($accountId, 'lastonline', 'CURRENT_TIMESTAMP()', false); // does not trigger another save
		$this->core->notifyMediator("DatabaseManager", "executeArray", 1, 'UPDATE', 'account', $this->getAccountDatabaseData($accountId), 'name', $this->getAccountDatabaseData($accountId, 'name'));
			
		$this->core->dispatchEvent('onAccountSave', $accountId);
			
		return true;
		
	}
	
	
	/**
	*
	* refreshLoginToken
	*
	* 
	*
	* @param int $accountId
	* @return void 
	*
	*/
	public function refreshLoginToken(int $accountId)
	{
		$this->setAccountDatabaseData($accountId, 'loginToken', $this->core->notifyMediator("CipherManager", "generateToken"), false); // no save
	}
	
	/**
	*
	* insertNewAccount
	*
	* Inserts the account as a new account into the database, is required instead
	* of 'saveAccount' in case of new accounts.
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function insertNewAccount(int $accountId) : bool
	{
	
		if (!$this->checkAccountValid($accountId) || !$this->accounts[$accountId]->hasChanged())
			return false;
			
		$this->core->notifyMediator("DatabaseManager", "executeArray", 1, 'INSERT INTO', 'account', $this->getAccountDatabaseData($accountId));
		
		return true;
		
	}
	
	/**
	*
	* loadAccountAdditive
	*
	* loads the account of the stated Id, using the provided data. loading always refreshes the in-memory data
	* this loading process requires at least the name of the account to be in the $data array
	*
	* @param int $accountId
	* @param array $data
	* @return bool 
	*
	*/
	public function loadAccountAdditive(int $accountId, string $uniqueId) : bool
	{
		
		$databaseData = array();
		
		if (!empty($uniqeId) || $accountId <=0)
			return false;
			
		/*
		* Reload from Database
		*/
		$databaseData = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, 'SELECT * FROM `account` WHERE `uniqueId`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $uniqueId);
		
		/*
		* Account does not exist, is banned etc.
		*/
		if ($databaseData == false || count($databaseData) <= 0)
			return false;
		
		$this->accounts[$accountId] = new Account($this->core);
		$this->accounts[$accountId]->parseDatabaseData($databaseData);

		return true;
		
	}
	
	/**
	* ====================================================================================
	*                                     ACCOUNT ACTIONS
	* ====================================================================================
	*/
	
	/**
	*
	* ACCOUNT REGISTRATION
	*
	*/
	
	/**
	*
	* canRegisterAccount
	*
	* Checks if a new account of the given name/email can be registered. Both names and
	* email addresses are unique and can be used for one account only.
	*
	* @param string $name
	* @param string email
	* @return bool 
	*
	*/
	public function canRegisterAccount(string $name, string $email) : bool
	{
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, 'SELECT * FROM `account` WHERE LOWER(`name`)=? OR email=?;', strtolower($name), $email);
		return ($data == NULL);
	}
	
	/**
	*
	* registerAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function registerAccount(int $accountId, array $data) : bool
	{
	
		if (!$this->canRegisterAccount($data['name'], $data['email']))
			return false;
		
		/*
		* Prepare Database Data
		*/
		$databaseData 						= array();
		$databaseData['name']				= $data['name'];
		$databaseData['email']				= $data['email'];
		
		if ($this->core->notifyMediator("LanguageManager", "hasLanguage", $data['language'])) {
			$databaseData['language']		= $data['language'];
		} else {
			$databaseData['language']		= $this->core->notifyMediator("LanguageManager", "getDefaultLanguage");
		}
		
		$databaseData['uniqueId'] 			= $this->core->notifyMediator("CipherManager", "generateUniqueId");
		$databaseData['passwordHash'] 		= $this->core->notifyMediator("CipherManager", "hashPassword", $data['password']);
		$databaseData['avatar'] 			= 'none.png';
		$databaseData['loginToken']			= $this->core->notifyMediator("CipherManager", "generateToken");
		$databaseData['securityToken']		= $this->core->notifyMediator("CipherManager", "generateToken");
		$databaseData['agent'] 				= Tools::getClientAgent(); 
		$databaseData['ip'] 				= Tools::getClientAddress();
		$databaseData['created'] 			= Tools::now();
		$databaseData['lastlogin'] 			= Tools::now();
		$databaseData['lastonline'] 		= Tools::now();
		$databaseData['lastriskyaction'] 	= Tools::now();
		$databaseData['lasttoken']		 	= Tools::now();
		
		$this->accounts[$accountId] = new Account($this->core);
		$this->accounts[$accountId]->parseTemporaryData($data);
		$this->accounts[$accountId]->parseDatabaseData($databaseData, true);
		$this->insertNewAccount($accountId);
		
		$this->core->dispatchEvent('onAccountRegister', $accountId);
		
		return true;
		
	}
	
	/**
	*
	* ACCOUNT LOGIN
	*
	*/
	
	/**
	*
	* loginAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function loginAccount(int $accountId, array $arguments) : bool
	{
	
		if ($this->loadAccount($accountId, $arguments)) {
		
			/*
			* saves account as well
			*/ 
			$this->setAccountDatabaseData($accountId, 'lastLogin', Tools::now());
			
			$this->core->dispatchEvent('onAccountLogin', $accountId);
			
			return true;
			
		}
		
		return false;
		
	}
	
	/**
	*
	* ACCOUNT LOGOUT
	*
	*/
	
	/**
	*
	* logoutAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function logoutAccount(int $accountId) : bool
	{
		$this->core->dispatchEvent('onAccountLogout', $accountId);
		$this->saveAccount($accountId);
		$this->accounts[$accountId] = NULL;
		return true;
	}
	
	/**
	*
	* ACCOUNT CONFIRMATION
	*
	*/
	
	/**
	*
	* requestConfirmAccount
	*
	* Generates a new security token and resets the expiration timer, also sends mail
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function requestConfirmAccount(int $accountId) : bool
	{
		return $this->requestSecurityTokenAndEmail($accountId, 'sendRegistrationConfirmation');
	}
	
	/**
	*
	* canConfirmAccount
	*
	* Checks if the account can be confirmed, uses the currently logged in account if no name is provided
	*
	* @param int $accountId
	* @param int $securityToken
	* @return bool 
	*
	*/
	public function canConfirmAccount(int $accountId, string $securityToken) : bool
	{
		
		$name = $this->getAccountDatabaseData($accountId, 'name');
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE LOWER(`name`)=? AND `securityToken`=? AND `banned`=0 AND `confirmed`=0 AND `deleted`=0 LIMIT 1", strtolower($name), $securityToken);
		
		return ($data != NULL);
		
	}
	
	/**
	*
	* confirmAccount
	*
	* @param int $accountId
	* @param int $securityToken
	* @return bool 
	*
	*/
	public function confirmAccount(int $accountId, string $securityToken) : bool
	{
	
		if (!$this->canConfirmAccount($accountId, $securityToken))
			return false;
		
		$this->setAccountDatabaseData($accountId, 'securityToken', 		'', 					false); 	// no save
		$this->setAccountDatabaseData($accountId, 'confirmed', 			1, 						false); 	// no save
		$this->setAccountDatabaseData($accountId, 'lasttoken', 			Tools::now(), 			false);		// no save
		$this->setAccountDatabaseData($accountId, 'lastriskyaction', 	Tools::now()); 			// now do save
			
		$this->core->dispatchEvent('onAccountConfirm', $accountId);
		
		return true;
		
	}
	
	/**
	*
	* ACCOUNT DELETION
	*
	*/
	
	/**
	*
	* requestDeleteAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function requestDeleteAccount(int $accountId) : bool
	{
		return $this->requestSecurityTokenAndEmail($accountId, 'sendDeleteAccount');		
	}
	
	/**
	*
	* canDeleteAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function canDeleteAccount(int $accountId, string $securityToken) : bool
	{
	
		if (!$this->checkRiskyAction($accountId))
			return false;
		
		$name = $this->getAccountDatabaseData($accountId, 'name');
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE LOWER(`name`)=? AND `securityToken`=? AND `banned`=0 AND `confirmed`=1 AND `deleted`=0 LIMIT 1", strtolower($name), $securityToken);
		
		return ($data != null);
		
	}
	
	/**
	*
	* deleteAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function deleteAccount(int $accountId, string $securityToken) : bool
	{
		if (!$this->canDeleteAccount($accountId, $securityToken))
			return false;
		
		$this->setAccountDatabaseData($accountId, 'securityToken', 		'', 					false); 	// no save
		$this->setAccountDatabaseData($accountId, 'deleted', 			1, 						false); 	// no save
		$this->setAccountDatabaseData($accountId, 'lasttoken', 			Tools::now(), 			false);		// no save
		$this->setAccountDatabaseData($accountId, 'lastriskyaction', 	Tools::now()); 			// now do save
		
		$this->core->dispatchEvent('onAccountDelete', $accountId);
			
		return true;
		
	}
	
	/**
	*
	* ACCOUNT RESET PASSWORD
	*
	*/
	
	/**
	*
	* requestResetAccountPassword
	*
	*
	* Note: This function is called while the user is LOGGED OUT
	*
	* @param string $email
	* @return bool 
	*
	*/
	public function requestResetAccountPassword(array $data) : bool
	{
		
		if ($data == NULL || empty($data) || empty($data['email']))
			return false;
		
		$databaseData = $this->core->notifyMediator("DatabaseManager", "executeScalar", 1, 'SELECT * FROM `account` WHERE `email`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $data['email']);
		
		/*
		* Account does not exist or is banned etc.
		*/
		if ($databaseData == null)
			return false;
		
		/*
		* Generate security token
		*/
		$securityToken = $this->core->notifyMediator("CipherManager", "generateToken");
		
		$databaseData = $this->core->notifyMediator("DatabaseManager", "executeQuery", 1, 'UPDATE `account` SET `securityToken`=? WHERE `email`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $securityToken, $data['email']);
		
		/*
		* Send password reset eMail
		*/
		$this->core->notifyMediator("MailManager", "sendResetPassword", $data['email'], $securityToken);
		
		return true;
		
	}
	
	/**
	*
	* canResetAccountPassword
	*
	*
	* Note: This function is called while the user is LOGGED OUT
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function canResetAccountPassword(string $securityToken) : bool
	{
	
		if (!$this->checkRiskyAction($accountId))
			return false;
		
		$accountId = 0;
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE `securityToken`=? AND `banned`=0 AND `deleted`=0 LIMIT 1", $securityToken);
		
		return ($data != null);
		
	}
	
	/**
	*
	* resetAccountPassword
	*
	*
	* Note: This function is called while the user is LOGGED OUT
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function resetAccountPassword(string $securityToken) : bool
	{
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeScalar", "SELECT * FROM `account` WHERE `securityToken`=? AND `banned`=0 AND `deleted`=0 LIMIT 1", $securityToken);
		
		/*
		* Account with this Token does not exist
		*/
		if ($data == NULL || empty($data))
			return false;
		
		$temporaryPassword = $this->core->notifyMediator("CipherManager", "generatePassword");
		
		$hashedPassword = $this->core->notifyMediator("CipherManager", "hashPassword", $temporaryPassword);
		
		$databaseData = $this->core->notifyMediator("DatabaseManager", "executeQuery", 1, 'UPDATE `account` SET `passwordHash`=? WHERE `securityToken`=? AND `banned`=0 AND `deleted`=0 LIMIT 1;', $hashedPassword, $securityToken);
		
		$this->core->notifyMediator("MailManager", "sendGeneratePassword", $data['email'], $temporaryPassword);
		
		$this->core->dispatchEvent('onAccountResetPassword', 0);
		
		return true;
		
	}
	
	/**
	*
	* ACCOUNT CHANGE PASSWORD
	*
	*/
	
	/**
	*
	* requestChangeAccountPassword
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function requestChangeAccountPassword(int $accountId, string $passwordNew) : bool
	{
		
		/*
		* This is not a valid Password
		*/
		if (!$this->validatePassword($passwordNew))
			return false;
		
		/*
		* If the password hashes match, its the same password and thats not what we want
		*/
		$passwordOld = $this->getAccountDatabaseData($accountId, 'passwordHash');
				
		if ($this->core->notifyMediator("CipherManager", "verifyPassword", $passwordNew, $passwordOld))
			return false;
		
		/*
		* Temporary store the new password
		*/
		$this->setAccountDatabaseData($accountId, 'newPassword', $passwordNew); 	// save
		
		return $this->requestSecurityTokenAndEmail($accountId, 'sendChangePassword');		
	}
	
	/**
	*
	* canChangeAccountPassword
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function canChangeAccountPassword(int $accountId, string $securityToken, string $passwordNew) : bool
	{
		
		if (!$this->checkRiskyAction($accountId))
			return false;
		
		/*
		* This is not a valid Password
		*/
		if (!$this->validatePassword($passwordNew))
			return false;
		
		/*
		* If the password hashes match, its the same password and thats not what we want
		*/
		$name 			= $this->getAccountDatabaseData($accountId, 'name');
		$passwordOld 	= $this->getAccountDatabaseData($accountId, 'passwordHash');
				
		if ($this->core->notifyMediator("CipherManager", "verifyPassword", $passwordNew, $passwordOld))
			return false;
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE `securityToken`=? AND `name`=? AND `banned`=0 AND `deleted`=0 LIMIT 1", $securityToken, $name);
		
		return ($data != null);
		
	}
	
	/**
	*
	* changeAccountPassword
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function changeAccountPassword(int $accountId, string $securityToken) : bool
	{
		
		$passwordNew = $this->getAccountDatabaseData($accountId, 'newPassword');
		
		if (!$this->canChangeAccountPassword($accountId, $securityToken, $passwordNew))
			return false;
		
		$passwordNew = $this->core->notifyMediator("CipherManager", "hashPassword", $passwordNew);
		
		$this->setAccountDatabaseData($accountId, 'securityToken', 		'', 					false); 	// no save
		$this->setAccountDatabaseData($accountId, 'passwordHash',		$passwordNew,			false); 	// no save
		$this->setAccountDatabaseData($accountId, 'newPassword',		'',						false); 	// no save
		$this->setAccountDatabaseData($accountId, 'lasttoken', 			Tools::now(), 			false);		// no save
		$this->setAccountDatabaseData($accountId, 'lastriskyaction', 	Tools::now()); 			// now do save
		
		$this->core->dispatchEvent('onAccountChangePassword', $accountId);
		
		return true;
			
	}
	
	/**
	*
	* ACCOUNT CHANGE EMAIL
	*
	*/
	
	/**
	*
	* requestChangeAccountEmail
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function requestChangeAccountEmail(int $accountId, string $eMailNew) : bool
	{
		
		/*
		* This is not a valid eMail
		*/
		if (!$this->validateEmail($eMailNew))
			return false;
		
		/*
		* When the eMails match the old and the new one are the same and thats not what we want
		*/
		$emailOld = $this->getAccountDatabaseData($accountId, 'email');
		
		/*
		* Temporary store the new eMail
		*/
		$this->setAccountDatabaseData($accountId, 'newEmail', $eMailNew); 	// save
		
		return $this->requestSecurityTokenAndEmail($accountId, 'sendChangeEmail');		
	}
	
	/**
	*
	* canChangeAccountEmail
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function canChangeAccountEmail(int $accountId, string $securityToken, string $eMailNew) : bool
	{
	
		if (!$this->checkRiskyAction($accountId))
			return false;
		
		/*
		* This is not a valid eMail
		*/
		if (!$this->validateEmail($eMailNew))
			return false;
		
		/*
		* When the eMails match the old and the new one are the same and thats not what we want
		*/
		$name 		= $this->getAccountDatabaseData($accountId, 'name');
		$emailOld 	= $this->getAccountDatabaseData($accountId, 'email');
		
		if ($eMailNew == $emailOld)
			return false;
		
		$data = $this->core->notifyMediator("DatabaseManager", "executeReader", 1, "SELECT * FROM `account` WHERE `securityToken`=? AND `name`=? AND `banned`=0 AND `deleted`=0 LIMIT 1", $securityToken, $name);
		
		return ($data != null);
		
	}
	
	/**
	*
	* changeAccountEmail
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function changeAccountEmail(int $accountId, string $securityToken) : bool
	{
		
		$eMailNew = $this->getAccountDatabaseData($accountId, 'newEmail');
		
		if (!$this->canChangeAccountEmail($accountId, $securityToken, $eMailNew))
			return false;
		
		$this->setAccountDatabaseData($accountId, 'securityToken', 		'', 					false); 	// no save
		$this->setAccountDatabaseData($accountId, 'email', 				$eMailNew,				false); 	// no save
		$this->setAccountDatabaseData($accountId, 'newEmail', 			'',						false); 	// no save
		$this->setAccountDatabaseData($accountId, 'lasttoken', 			Tools::now(), 			false);		// no save
		$this->setAccountDatabaseData($accountId, 'lastriskyaction', 	Tools::now()); 			// now do save
		
		$this->core->dispatchEvent('onAccountChangeEmail', $accountId);
		
		return true;
	
	}
	
	/**
	*
	* ACCOUNT BAN (---UNFINISHED---)
	*
	*/
	
	/**
	*
	* canBanAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function canBanAccount(int $accountId, $name, $password) : bool
	{
		if (!$this->checkRiskyAction($accountId))
			return false;
			
		return true;
	}
	
	/**
	*
	* banAccount
	*
	* @param int $accountId
	* @return bool 
	*
	*/
	public function banAccount(int $accountId, $name, $password) : bool
	{
	
		if (!$this->canBanAccount($accountId, $name, $password))
			return false;
		
		
		#
		#
		#
		
		$this->core->dispatchEvent('onAccountBan');
			
		return true;
		
	}
	
	/**
	*
	* ACCOUNT ADMIN (---UNFINISHED---)
	*
	*/
	
	/**
	*
	* canAdminAccount
	*
	* @return bool 
	*
	*/
	public function canAdminAccount() : bool
	{
	
		if (!$this->checkRiskyAction($accountId))
			return false;
			
		return true;
		
	}
	
	/**
	*
	* adminAccount
	*
	* @return bool 
	*
	*/
	public function adminAccount(int $accountId) : bool
	{
		
		if (!$this->checkRiskyAction($accountId))
			return false;
			
		#
		#
		#
		
		return true;
		
	}
	
	/**
	* ====================================================================================
	*                                PUBLIC WRAPPERS
	* ====================================================================================
	*/
	
	/**
	*
	* getAccountTemporaryData
	*
	* Wrapper to retrieve temporary data for the given key from the given account
	*
	* @param int $accountId
	* @param string $key
	* @return mixed|array|null
	*
	*/
	public function getAccountTemporaryData(int $accountId, string $key='')
	{
		return $this->accounts[$accountId]->getTemporaryData($key);
	}
	
	/**
	*
	* setAccountTemporaryData
	*
	* Sets temporary data to the given account, returns TRUE on success, or FALSE on failure
	*
	* @return bool 
	*
	*/
	public function setAccountTemporaryData(int $accountId, string $key, $value) : bool
	{
		return $this->accounts[$accountId]->setTemporaryData($key, $value);
	}
	
	/**
	*
	* getAccountDatabaseData
	*
	* Retrieves permanent data for the given key from the given account
	*
	* @return mixed
	*
	*/
	public function getAccountDatabaseData(int $accountId, string $key='')
	{
		return $this->accounts[$accountId]->getDatabaseData($key);
	}
	
	/**
	*
	* setAccountDatabaseData
	*
	* Sets permanent data to the account, returns TRUE on success, or FALSE on failure
	*
	* @return bool 
	*
	*/
	public function setAccountDatabaseData(int $accountId, string $key, $value, bool $saveAccount=true) : bool
	{
	
		$ok = $this->accounts[$accountId]->setDatabaseData($key, $value);
		
		if ($saveAccount)
			$this->saveAccount($accountId);
			
		$this->core->dispatchEvent('onAccountUpdate', $accountId);
			
		return $ok;
	}
	
	/**
	*
	* getRiskyActionDelay
	*
	* @return int 
	*
	*/
	public function getRiskyActionDelay() : int
	{
		return $this->config::CONST_RISKY_ACTION_DELAY;
	}
	
}