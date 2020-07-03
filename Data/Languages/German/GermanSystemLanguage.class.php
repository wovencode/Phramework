<?php
namespace phramework;
use phramework;

/**
*
* GermanSystemLanguage
*
* Contains word data for the given language for system only.
*
* @author Fhiz
* @version 1.0
*
*/
class GermanSystemLanguage
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
		$this->data['subTitle'] 			= 'Browser Spiel Engine';
		$this->data['pressToStart'] 		= 'Einloggen oder Registrieren um zu Starten';
		$this->data['copyrightNotice'] 		= 'Copyright 2020+ by Fhiz';
		
		$this->data['index'] 				= 'Index';
		$this->data['home'] 				= 'Home';
		$this->data['register'] 			= 'Registrieren';
		$this->data['login'] 				= 'Einloggen';
		$this->data['logout'] 				= 'Ausloggen';
		
		$this->data['profile'] 				= 'Profil';
		$this->data['settings'] 			= 'Einstellungen';
		$this->data['list'] 				= 'Nutzerliste';
		$this->data['submit'] 				= 'Absenden';
		$this->data['avatar'] 				= 'Avatar';
		
		$this->data['username'] 			= 'Benutzername';
		$this->data['password'] 			= 'Passwort';
		$this->data['email'] 				= 'eMail';
		$this->data['language'] 			= 'Sprache';
		$this->data['rememberMe'] 			= 'Eingeloggt bleiben';
		
		$this->data['created'] 				= 'Erstellt';
		$this->data['lastlogin'] 			= 'Letzter login';
		$this->data['lastonline'] 			= 'Zuletzt aktiv';
		
		$this->data['confirmed'] 			= '[Best&auml;stigt]';
		$this->data['unconfirmed'] 			= '[Nicht best&auml;tigt]';
		
		$this->data['registerUsername'] 	= '4+ alphanumerische zeichen';
		$this->data['registerPassword'] 	= '4+ alphanumerische zeichen';
		$this->data['registerEmail'] 		= 'G&uuml;ltige eMail Adresse';
		
		$this->data['accessDenied'] 		= 'Zugriff verweigert!';
		$this->data['loginToContinue'] 		= 'Einloggen um fortzufahren.';
		
		/*
		* General Substantives
		*/
		$this->data['substantivePage'] 		= 'Seite';
		
		/*
		* Forgot Password
		*/
		$this->data['forgotPassword'] 		= 'Passwort vergessen';
		
		/*
		* Change Email
		*/
		$this->data['changeEmail'] 					= 'eMail &auml;ndern';
		$this->data['changeEmailSuccess'] 			= 'eMail ge&auml;ndert!';
		$this->data['changeEmailFailure'] 			= 'eMail &auml;ndern fehlgeschlagen.';
		$this->data['changeEmailRequest'] 			= 'eMail &auml;ndern eMail gesendet.';
		
		/*
		* Change Password
		*/
		$this->data['changePassword'] 				= 'Passwort &auml;ndern';
		$this->data['changePasswordSuccess'] 		= 'Passwort ge&auml;ndert!';
		$this->data['changePasswordFailure'] 		= 'Passwort &auml;ndern fehlgeschlagen.';
		$this->data['changePasswordRequest'] 		= 'Passwort &auml;ndern eMail gesendet.';
		
		/*
		* Adverbs
		*/
		$this->data['adverbOf'] 					= 'von';
		
		/*
		* New / Old
		*/
		$this->data['current'] 				= '(Derzeit)';
		$this->data['new'] 					= '(Neu)';
		
		/*
		* Time
		*/
		$this->data['timeDayAgo'] 			= 'vor %s Tag';
		$this->data['timeDaysAgo'] 			= 'vor %s Tagen';
		$this->data['timeWaitMinute'] 		= '(Erlaubt in %s Minute)';
		$this->data['timeWaitMinutes'] 		= '(Erlaubt in %s Minuten)';
		
		/*
		* Info
		*/
		$this->data['infoSettings'] 		= 'Kontobest&auml;tigung f&uuml;r einige Optionen ben&ouml;tigt.';
		$this->data['infoConfirm'] 			= 'Erst Konto best&auml;tigen.';
		
		/*
		* Upload Avatar
		*/
		$this->data['avatarSuccess'] 		= 'Profilbild hochgeladen!';
		$this->data['avatarFailure'] 		= 'Profilbild hochladen fehlgeschlagen.';
		$this->data['avatarFooter'] 		= 'Falsches Dateiformat oder Maximalgr&ouml;&szlig;e &uuml;berschritten.';
		
		/*
		* Confirm Account
		*/
		$this->data['confirmAccount'] 		= 'Konto best&auml;tigen';
		$this->data['confirmSuccess'] 		= 'Konto best&auml;tigt!';
		$this->data['confirmFailure'] 		= 'Best&auml;tigung fehlgeschlagen.';
		$this->data['confirmRequest'] 		= 'Best&auml;tigungs eMail gesendet.';
		
		/*
		* Delete Account
		*/
		$this->data['deleteAccount'] 		= 'Konto l&ouml;schen';
		$this->data['deleteSuccess'] 		= 'Konto gel&ouml;scht!';
		$this->data['deleteFailure'] 		= 'Konto l&ouml;schen fehlgeschlagen.';
		$this->data['deleteFooter'] 		= 'Name/eMail in einigen Tagen wieder verf&uuml;gbar.';
		$this->data['deleteRequest'] 		= 'eMail zur Konto L&ouml;schung gesendet.';
		
		/*
		* Reset Account Password
		*/
		$this->data['resetSuccess'] 		= 'Passwort zur&uuml;ckgesetzt!';
		$this->data['resetFailure'] 		= 'Passwort zur&uuml;cksetzen fehlgeschlagen.';
		$this->data['resetRequest'] 		= 'Passwort reset eMail gesendet.';
		
		/*
		* Popup
		*/
		$this->data['failureFooter'] 		= 'Warte eine weitere Minute und versuche es nochmal.';
		
	}
		
}