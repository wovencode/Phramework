<?php
namespace phramework;
use phramework;

/**
*
* EnglishSystemLanguage
*
* Contains word data for the given language for system only.
*
* @author Fhiz
* @version 1.0
*
*/
class EnglishSystemLanguage
{
	
	public $data = array();
	
	/*
	*
	* Constructor
	*
	*/
	public function __construct()
	{
	
		$this->data['gameTitle'] 			= 'Phramework';
		$this->data['subTitle'] 			= 'Login & Account System';
		$this->data['pressToStart'] 		= 'Login or Register to Start';
		$this->data['copyrightNotice'] 		= 'Copyright 2020+ by Fhiz';
	
		$this->data['index'] 				= 'Index';
		$this->data['home'] 				= 'Home';
		$this->data['register'] 			= 'Register';
		$this->data['login'] 				= 'Login';
		$this->data['logout'] 				= 'Logout';
		
		$this->data['profile'] 				= 'Profile';
		$this->data['settings'] 			= 'Settings';
		$this->data['list'] 				= 'Userlist';
		$this->data['submit'] 				= 'Submit';
		$this->data['avatar'] 				= 'Avatar';
		
		$this->data['username'] 			= 'Username';
		$this->data['password'] 			= 'Password';
		$this->data['email'] 				= 'eMail';
		$this->data['language'] 			= 'Language';
		$this->data['rememberMe'] 			= 'Remember Me';
		
		$this->data['created'] 				= 'Created';
		$this->data['lastlogin'] 			= 'Last login';
		$this->data['lastonline'] 			= 'Last active';
		
		$this->data['confirmed'] 			= '[Confirmed]';
		$this->data['unconfirmed'] 			= '[Unconfirmed]';
		
		$this->data['registerUsername'] 	= '4+ alphanumeric characters';
		$this->data['registerPassword'] 	= '4+ alphanumeric characters';
		$this->data['registerEmail'] 		= 'Your valid eMail address';
		
		$this->data['accessDenied'] 		= 'Access denied!';
		$this->data['loginToContinue'] 		= 'Login in order to continue.';
		
		/*
		* General Substantives
		*/
		$this->data['substantivePage'] 		= 'Page';
		
		/*
		* Forgot Password
		*/
		$this->data['forgotPassword'] 		= 'Forgot Password';
		
		/*
		* Change Email
		*/
		$this->data['changeEmail'] 					= 'Change eMail';
		$this->data['changeEmailSuccess'] 			= 'eMail changed!';
		$this->data['changeEmailFailure'] 			= 'eMail change failed.';
		$this->data['changeEmailRequest'] 			= 'eMail change eMail sent.';
		
		/*
		* Change Password
		*/
		$this->data['changePassword'] 				= 'Change Password';
		$this->data['changePasswordSuccess'] 		= 'Password changed!';
		$this->data['changePasswordFailure'] 		= 'Passwort change failed.';
		$this->data['changePasswordRequest'] 		= 'Passwort change eMail sent.';
		
		/*
		* Adverbs
		*/
		$this->data['adverbOf'] 					= 'of';
		
		
		/*
		* New / Old
		*/
		$this->data['current'] 				= '(Current)';
		$this->data['new'] 					= '(New)';
		
		/*
		* Time
		*/
		$this->data['timeDayAgo'] 			= '%s day ago';
		$this->data['timeDaysAgo'] 			= '%s days ago';
		$this->data['timeWaitMinute'] 		= '(Enabled in %s minute)';
		$this->data['timeWaitMinutes'] 		= '(Enabled in %s minutes)';
		
		/*
		* Info
		*/
		$this->data['infoSettings'] 		= 'Some options require Account confirmation.';
		$this->data['infoConfirm'] 			= 'Confirm account first.';
		
		/*
		* Upload Avatar
		*/
		$this->data['avatarSuccess'] 		= 'Avatar uploaded!';
		$this->data['avatarFailure'] 		= 'Avatar upload failed.';
		$this->data['avatarFooter'] 		= 'Fileformat mismatch or max filesize exceeded.';
		
		/*
		* Confirm Account
		*/
		$this->data['confirmAccount'] 		= 'Confirm Account';
		$this->data['confirmSuccess'] 		= 'Account confirmed!';
		$this->data['confirmFailure'] 		= 'Confirmation failed.';
		$this->data['confirmRequest'] 		= 'Confirmation mail sent.';
		
		/*
		* Delete Account
		*/
		$this->data['deleteAccount'] 		= 'Delete Account';
		$this->data['deleteSuccess'] 		= 'Account deleted!';
		$this->data['deleteFailure'] 		= 'Account deletion failed.';
		$this->data['deleteFooter'] 		= 'Name/eMail available in a few days again.';
		$this->data['deleteRequest'] 		= 'Account deletion mail sent.';
		
		/*
		* Reset Account Password
		*/
		$this->data['resetSuccess'] 		= 'Password reset!';
		$this->data['resetFailure'] 		= 'Password reset failed.';
		$this->data['resetRequest'] 		= 'Password reset eMail sent.';
		
		/*
		* Popup
		*/
		$this->data['failureFooter'] 		= 'Wait another minute and try again.';
	}
	
}