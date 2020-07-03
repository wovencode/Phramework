<?php
namespace phramework;
use phramework;

/**
*
* CipherManagerConfig
*
* @author Fhiz
* @version 1.0
*
*/
class CipherManagerConfig extends BaseConfig
{
	
	public string $eventResolver = "";
	
	public const CONST_CIPHER_SECRET_KEY 		= "my_simple_secret_key";
	public const CONST_CIPHER_SECRET_IV			= "my_simple_secret_iv";
	public const CONST_CIPHER_ENCRYPT_METHOD	= "AES-256-CBC";
	public const CONST_CIPHER_METHOD			= "sha256";
	public const CONST_CIPHER_PEPPER			= "ph";
	public const CONST_CIPHER_PREFIX			= "ph";
	
}