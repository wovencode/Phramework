<?php
namespace phramework;
use phramework;
use PHPMailer\PHPMailer;

/**
*
* MailManager
*
* Responsible for building and sending eMails out to clients, comes with several readymade eMail templates
*
* @author Fhiz
* @version 1.0
*
*/
final class MailManager extends BaseManager
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
		$this->configName = "MailManagerConfig";
		parent::__construct($core);
	}
	
	/**
	*
	* Initialize (Overridden)
	*
	*/
	protected function initialize()
	{
		require_once Tools::buildPath(2, "Exception.php", 	'', 	array($this->config::CONST_ENGINE, $this->config::CONST_PLUGINS, 'phpmailer', 'src'));
		require_once Tools::buildPath(2, "PHPMailer.php", 	'', 	array($this->config::CONST_ENGINE, $this->config::CONST_PLUGINS, 'phpmailer', 'src'));
		require_once Tools::buildPath(2, "SMTP.php", 		'', 	array($this->config::CONST_ENGINE, $this->config::CONST_PLUGINS, 'phpmailer', 'src'));
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
	
	/**
	*
	* sendMail
	*
	*/
	private function sendMail($email, $subject, $body) : bool
	{
		
		if (Tools::mempty($email, $subject, $body))
			return false;
		
		$mail = new PHPMailer\PHPMailer;
		#$mail->isSMTP();
		#$mail->SMTPDebug 		= 0;
		#$mail->SMTPAutoTLS 	= true;
		#$mail->SMTPAuth 		= true;
		$mail->Debugoutput 		= 'html';
		$mail->Host 			= $this->config::CONST_MAIL_HOST;
		$mail->Port 			= $this->config::CONST_MAIL_PORT;
		$mail->Username 		= $this->config::CONST_MAIL_EMAIL;
		$mail->Password 		= $this->config::CONST_MAIL_PASSWORD;
		$mail->setFrom($this->config::CONST_MAIL_ECONST_MAIL_FROM, $this->config::CONST_MAIL_ECONST_MAIL_REPLY);
		$mail->addReplyTo($this->config::CONST_MAIL_ECONST_MAIL_FROM, $this->config::CONST_MAIL_ECONST_MAIL_REPLY);
		$mail->addAddress($email, $email);
		$mail->Subject 			= $subject;
		$mail->msgHTML($body);
		#$mail->AltBody 		= $message;
		
		return $mail->send();
		
	}
	
	
	/**
	*
	* buildMail
	*
	* Builds and sends an eMail using the available data, subject, body and template
	*
	* @return bool
	*
	*/
	private function buildMail(string $eMail, string $subjectToken, string $textToken, string $bodyTemplate, string $data) : bool
	{
	
		$templateTokens = array();
		
		$templateTokens['data'] = $data;
		$templateTokens['text'] = $this->core->notifyMediator("LanguageManager", "getLanguage", $textToken, $this->config::CONST_MAIL);
		
		$subject 	= $this->core->notifyMediator("LanguageManager", "getLanguage", $subjectToken, $this->config::CONST_MAIL);
		$body 		= $this->core->notifyMediator("TemplateManager", "parseTemplate", $bodyTemplate, $templateTokens, $this->config::CONST_MAIL);
		
		return $this->sendMail($eMail, $subject, $body);
	
	}
	
	/*
	* ====================================================================================
	*                                       PUBLIC
	* ====================================================================================
	*/
	
	/**
	*
	* sendRegistrationConfirmation
	*
	* @return bool
	*
	*/
	public function sendRegistrationConfirmation($eMail, $code) : bool
	{
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountConfirmPage');
		$link = $this->config::CONST_DOMAIN . $link . "&c=" . $code;
		
		return $this->buildMail($eMail, 'MailAccountConfirmSubject', 'confirmAccountText', 'MailAccountConfirm', $link);
		
	}
	
	/**
	*
	* sendResetPassword
	*
	* @return bool
	*
	*/
	public function sendResetPassword($eMail, $code) : bool
	{
		
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountResetPasswordPage');
		$link = $this->config::CONST_DOMAIN . $link . "&c=" . $code;
		
		return $this->buildMail($eMail, 'MailForgotPasswordSubject', 'forgotPasswordText', 'MailAccountForgotPassword', $link);
		
	}
	
	/**
	*
	* sendGeneratePassword
	*
	* @return bool
	*
	*/
	public function sendGeneratePassword($eMail, $password) : bool
	{
		return $this->buildMail($eMail, 'MailGeneratePasswordSubject', 'generatePasswordText', 'MailAccountGeneratePassword', $password);
	}
	
	/**
	*
	* sendChangePassword
	*
	* @return bool
	*
	*/
	public function sendChangePassword($eMail, $code) : bool
	{
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountChangePasswordPage');
		$link = $this->config::CONST_DOMAIN . $link . "&c=" . $code;
		
		return $this->buildMail($eMail, 'MailChangePasswordSubject', 'changePasswordText', 'MailAccountChangePassword', $link);
		
	}
	
	/**
	*
	* sendChangeEmail
	*
	* @return bool
	*
	*/
	public function sendChangeEmail($eMail, $code) : bool
	{
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountChangeEmailPage');
		$link = $this->config::CONST_DOMAIN . $link . "&c=" . $code;
		
		return $this->buildMail($eMail, 'MailChangeEmailSubject', 'changeEmailText', 'MailAccountChangeEmail', $link);
		
	}
	
	/**
	*
	* sendDeleteAccount
	*
	* @return bool
	*
	*/
	public function sendDeleteAccount($eMail, $code) : bool
	{
		$link = $this->core->notifyMediator("RouterManager", "getRouteLink", 'AccountDeletePage');
		$link = $this->config::CONST_DOMAIN . $link . "&c=" . $code;
		
		return $this->buildMail($eMail, 'MailAccountDeleteSubject', 'deleteAccountText', 'MailAccountDelete', $link);
				
	}
		
}