<?php
namespace phramework;
use phramework;

/**
*
* EnglishMailLanguage
*
* Contains word data for the given language for emails only.
*
*
* @author Fhiz
* @version 1.0
*
*/
class EnglishMailLanguage
{
	
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->data['MailAccountConfirmSubject'] 	= 'Confirm your Account';
		$this->data['MailForgotPasswordSubject'] 	= 'Forgotten Password';
		$this->data['MailGeneratePasswordSubject'] 	= 'Your generated Password';
		$this->data['MailChangePasswordSubject'] 	= 'Change your Password';
		$this->data['MailChangeEmailSubject'] 		= 'Change your Email Address';
		$this->data['MailAccountDeleteSubject'] 	= 'Delete your account';
		
		$this->data['generatePasswordText'] 	= 'We generated a new temporary password for your account. Please use it to login and change your password manually afterwards.';
		$this->data['forgotPasswordText'] 		= 'You receive this email because you requested a new password for your account. Please click the button below, to generate a temporary password.';
		$this->data['changePasswordText'] 		= 'You receive this email because you want to change the password of your account. Please click the button below, to confirm the new password.';
		$this->data['changeEmailText'] 			= 'You receive this email because you want to change the email address of your account. Please click the button below, to confirm the new email address.';
		$this->data['deleteAccountText'] 		= 'You receive this email because you want to delete your account. Please click the button below, to finish account deletion.';
		$this->data['confirmAccountText'] 		= 'You receive this email because you need to confirm your account. Please click the button below, to complete confirmation.';
	}
	
}