<?php
namespace phramework;
use phramework;

/**
*
* CipherManager
*
* Simple encryption/decryption class with SSL strength.
*
* @author Fhiz
* @version 1.0
*
*/
final class CipherManager extends BaseManager
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
		$this->configName 		= "CipherManagerConfig";
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
	*                                       PRIVATE
	* ====================================================================================
	*/
	
	/*
	*
	* encryptDecrypt
	*
	* encrypt: $encrypted = my_simple_crypt( 'Hello World!', 'e' );
	* decrypt: $decrypted = my_simple_crypt( 'RTlOMytOZStXdjdHbDZtamNDWFpGdz09', 'd' );
	*
	* @param string $string
	* @param string $action e = encryt / d = decrypt
	* @return string
	*
	*/
	private function encryptDecrypt(string $string, string $action = 'e') : string
	{
	
		$output = "";
		
		$key 	= hash($this->config::CONST_CIPHER_METHOD, $this->config::CONST_CIPHER_SECRET_KEY );
		$iv 	= substr(hash($this->config::CONST_CIPHER_METHOD, $this->config::CONST_CIPHER_SECRET_IV ), 0, 16 );
 	
		if ( $action == 'e' ) {
			$output = base64_encode(openssl_encrypt($string, $this->config::CONST_CIPHER_ENCRYPT_METHOD, $key, 0, $iv ) );
		}
		else if ( $action == 'd' ) {
			$output = openssl_decrypt(base64_decode($string), $this->config::CONST_CIPHER_ENCRYPT_METHOD, $key, 0, $iv );
		}
 
		return $output;
	}
	
	/*
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/*
	*
	* encrypt
	*
	*
	* @param string $string
	*
	*/
	public function encrypt(string $string) : string
	{
		return $this->encryptDecrypt($string, 'e');
	}
	
	/*
	*
	* decrypt
	*
	*
	* @param string $string
	* @return string
	*
	*/
	public function decrypt(string $string) : string
	{
		return $this->encryptDecrypt($string, 'd');
	}
	
	/*
	*
	* generateUniqueId
	*
	*
	* @return string
	*
	*/
	public function generateUniqueId() : string
	{
		return str_ireplace('.', '', uniqid($this->config::CONST_CIPHER_PREFIX, true));
	}
	
	/*
	*
	* generateToken
	*
	*
	* @return string
	*
	*/
	public function generateToken(int $length=32) : string
	{
		if (function_exists('random_bytes')) {
   			return bin2hex(random_bytes($length));
  		} else if (function_exists('mcrypt_create_iv')) {
    		return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
  		} else {
    		return bin2hex(openssl_random_pseudo_bytes($length));
  		}
	}
	
	/**
	 * Generate a random string, using a cryptographically secure 
	 * pseudorandom number generator (random_int)
	 * 
	 * @param 	int 	$length		How many characters do we want?
	 * @param 	string 	$keyspace 	A string of all possible characters to select from
	 * @return 	string
	 *
	 */
	public function generatePassword($length=8, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		if ($max < 1) {
			throw new Exception('$keyspace must be at least two characters long');
		}
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}
	
	/*
	*
	* generateChecksum
	*
	* Generates a checksum taking all arguments into account
	*
	* @param mixed
	* @return string
	*
	*/
	public function generateChecksum() : string
	{
		$checksum = NULL;
		foreach(func_get_args() as $arg)
			$checksum .= $arg;
		return md5($checksum);
	}
	
	/*
	*
	* generateChecksumFromArray
	*
	* Same as above but uses an Array to generate checksum
	*
	* @param mixed
	* @return string
	*
	*/
	public function generateChecksumFromArray(array $data) : string
	{
		$checksum = NULL;
		foreach($data as $arg)
			$checksum .= $arg;
		return md5($checksum);
	}
	
	/*
	*
	* hashPassword
	*
	* 
	*
	* @param 
	* @return string
	*
	*/
	public function hashPassword(string $password, string $hash=PASSWORD_DEFAULT) : string
	{
		return password_hash($password . $this->config::CONST_CIPHER_PEPPER, $hash);
	}
	
	/*
	*
	* verifyPassword
	*
	* 
	*
	* @param 
	* @return bool
	*
	*/
	public function verifyPassword(string $password, string $passwordHash) : bool
	{
		return password_verify($password . $this->config::CONST_CIPHER_PEPPER, $passwordHash);
	}
		
}