<?php
namespace phramework;
use phramework;

/**
*
* GermanMailLanguage
*
* Contains word data for the given language for emails only.
*
*
* @author Fhiz
* @version 1.0
*
*/
class GermanMailLanguage
{
	
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
		
		$this->data['MailAccountConfirmSubject'] 	= 'Best&auml;tige dein Konto';
		$this->data['MailForgotPasswordSubject'] 	= 'Passwort vergessen';
		$this->data['MailGeneratePasswordSubject'] 	= 'Dein neues Passwort';
		$this->data['MailChangePasswordSubject'] 	= '&Auml;ndere dein Passwort';
		$this->data['MailChangeEmailSubject'] 		= '&Auml;ndere deine eMail Adresse';
		$this->data['MailAccountDeleteSubject'] 	= 'L&ouml;sche dein Konto';
	
		$this->data['generatePasswordText'] 		= 'Wir haben ein neues temporäres Passwort für Ihr Konto generiert. Bitte verwenden Sie es, um sich anzumelden und Ihr Passwort anschließend manuell zu ändern.';
		$this->data['forgotPasswordText'] 			= 'Sie erhalten diese E-Mail, weil Sie ein neues Passwort für Ihr Konto angefordert haben. Bitte klicken Sie auf die Schaltfläche unten, um ein temporäres Passwort zu generieren.';
		$this->data['changePasswordText'] 			= 'Sie erhalten diese E-Mail, weil Sie das Passwort Ihres Kontos ändern möchten. Bitte klicken Sie auf die Schaltfläche unten, um das neue Passwort zu bestätigen.';
		$this->data['changeEmailText'] 				= 'Sie erhalten diese E-Mail, weil Sie die E-Mail-Adresse Ihres Kontos ändern möchten. Bitte klicken Sie auf die Schaltfläche unten, um die neue E-Mail-Adresse zu bestätigen.';
		$this->data['deleteAccountText'] 			= 'Sie erhalten diese E-Mail, weil Sie Ihr Konto löschen möchten. Bitte klicken Sie auf die Schaltfläche unten, um das Löschen des Kontos abzuschließen.';
		$this->data['confirmAccountText'] 			= 'Sie erhalten diese E-Mail, weil Sie Ihr Konto bestätigen m&uuml;ssen. Bitte klicken Sie auf die Schaltfläche unten, um die Bestätigung abzuschließen.';
	
	
	}
		
}