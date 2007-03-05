<?PHP
if (!defined('SYSINFO')) exit;
if (isset($_REQUEST['ll'])) $lang = strip_tags($_REQUEST['ll']);
else $lang = substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2);

$llang = "english";
$lang_warning = "eyeOS Warning";
$lang_notrun = "Your web sever configuration does not allow eyeOS to run.";
$lang_phpini = "This is due to the parameter '<strong>safe_mode</strong>' is set to '<strong>on</strong>' in your '<strong>php.ini</strong>' file. If you have access to that file, you could change 'safe_mode' to 'Off' and restart your web server in order to use eyeOS.";
$lang_beyondcontrol = "We apologize for this situation which is beyond our control.";
$lang_enterall = "Please enter all information requested";
$lang_pwdnotmatch = "Passwords do not match, please reenter";
$lang_nocreatefile = "Failed to create file %1";
$lang_nocreatedir = "Failed to create directory %0";
$lang_rootuserval = "%0 eyeOS root user email validation : %1";
$lang_failedsendmail = "Sending of validation email failed";
$lang_statsdirnot = "Statistics directory, %0, not created or not writeable";
$lang_notwritesys = "Cannot write to system definition file";
$lang_title = "eyeOS ".OSVERSION." Installation Script";
$lang_setpermissions = "Please set permissions of 0777 on the following directories : ";
$lang_usereload = "Then use your browser reload button to retry the installation";
$lang_back = "Back to Installation parameters";
$lang_sysnotwrite = "The system definition file sysdefs.php is not writeable. In order to change these parameters you will need to change the permissions on that file to allow PHP to write to it. You may reset the permissions after installation completes";
$lang_setvalues = "Set security values";
$lang_welcome = "Welcome to eyeOS installation script.";
$lang_text = "Before using your new eyeOS system, you need specify some system parameters.<br/>The install process will be completed in a minute!";
$lang_advanced = "Advanced security parameters";
$lang_specifyname = "Specify a name for your new eyeOS system :";
$lang_deflanguage = "Choose the default language :";
$lang_email = "Root user email address (see note below) :";
$lang_specifypwd = "Specify the password for user \"%0\", the root user :";
$lang_retypepwd = "Retype root user password :";
$lang_install = "Install eyeOS >>";
$lang_validation = "Email address is needed only if you intend to enable email validation of user created accounts. <br/>This feature is enabled if the root user email address is validated and <br/>if the file validate.txt is present in the login directory.";

switch ($lang) {
case "ar" :
	$llang = "arabic";
break;
case "ms" :
	$llang = "bahasa melayu";
break;
case "bn" :
	$llang = "bangla";
break;
case "pt_BR" :
	$llang = "brasileiro/português";
break;
case "bg" :
	$llang = "bulgarian";
break;
case "ca" :
	$llang = "català";
break;
case "cs" :
	$llang = "český";
break;
case "zh" :
	$llang = "chinese";
break;
case "hr" :
	$llang = "croatian";
break;
case "da" :
	$llang = "dansk";
break;
case "de" :
	$llang = "deutsch";
    $lang_warning = "eyeOS Warnung";
    $lang_notrun = "Ihre Server-Einstellungen erlauben leider keine eyeOS-Installation.";
    $lang_phpini = "Wenn Sie Ihre Server-Einstellungen mit einer '<strong>php.ini</strong>'-Datei ändern können, setzen Sie bitte den '<strong>safe_mode=off</strong>'.";
    $lang_beyondcontrol = "Wir entschuldigen uns für diese Situation, die über unserer Steuerung hinaus geht.";
    $lang_enterall = "Bitte geben Sie alle geforderten Daten an";
    $lang_pwdnotmatch = "Die Passwörter passten nicht überein, bitte wiederholen Sie Ihre Eingabe";
    $lang_nocreatefile = "Die Datei %0 konnte nicht erstellt werden";
    $lang_nocreatedir = "Der Ordner %0 konnte nicht erstellt werden";
    $lang_rootuserval = "%0 eyeOS-Root-Benutzer-E-Mail-Überprüfung : %1";
    $lang_failedsendmail = "Das senden der Aktivierungs-E-Mail schlug fehl";
    $lang_statsdirnot = "Der Statistiken-Ordner, %0, konnte nicht erstellt werden oder ist nicht beschreibbar";
    $lang_notwritesys = "Die Systemeinstellungs-Datei konnte nicht beschrieben werden";
    $lang_title = "eyeOS ".OSVERSION."-Installation";
    $lang_setpermissions = "Bitte erstellen Sie folgende Ordner manuell und setzen Sie die Rechte auf 777 : ";
    $lang_usereload = "Klicken Sie dann auf den Neu Laden-Button, um die Installation neu zu starten";
    $lang_back = "Zurück";
    $lang_sysnotwrite = "Die Systemeinstellungs-Datei, sysdefs.php, kann nicht beschrieben werden. Ändern Sie deshalb bitte die Dateirechte um die Datei mit PHP zu beschreiben. Danach sollten Sie die Installation neu starten.";
    $lang_setvalues = "Speichern";
    $lang_welcome = "Willkommen zur eyeOS-Installation";
    $lang_text = "Bevor Sie Ihr neues eyeOS-System benutzen können, müssen Sie es kurz einrichten.<br/>Bitte geben Sie alle geforderten Daten an!";
    $lang_advanced = "Erweiterte Einstellungen";
    $lang_specifyname = "Geben Sie einen Namen für Ihr eyeOS-System an :";
    $lang_deflanguage = "Wählen Sie eine Standard-Sprache :";
    $lang_email = "Root-Benutzer-E-Mail (siehe unten) :";
    $lang_specifypwd = "Geben Sie ein Passwort für \"%0\", den Root-Benutzer an :";
    $lang_retypepwd = "Wiederholen Sie das Passwort :";
    $lang_install = "eyeOS installieren >>";
    $lang_validation = "Die E-Mail-Adresse wird nur benötigt, wenn Sie das Überprüfen jedes neuen Accounts aktivieren möchten. <br/>Das Feature wird dann aktiviert, wenn die Root-Benutzer-E-Mail überprüft wurde und <br/>wenn die Datei validate.txt in dem login-Ordner existiert.";
break;
case "es" :
	$llang = "español";
break;
case "eu" :
	$llang = "euskara";
break;
case "fr" :
	$llang = "français";
break;
case "gl" :
	$llang = "galego";
break;
case "el" :
	$llang = "greek";
break;
case "it" :
	$llang = "italiano";
break;
case "ja" :
	$llang = "japanese";
break;
case "ko" :
	$llang = "korean";
break;
case "hu" :
	$llang = "magyar";
break;
case "nl" :
	$llang = "nederlands";
break;
case "no" :
	$llang = "norsk";
break;
case "ir" :
	$llang = "persian";
break;
case "pl" :
	$llang = "polski";
break;
case "pt" :
	$llang = "português";
break;
case "ro" :
	$llang = "românesc";
break;
case "ru" :
	$llang = "russian";
break;
case "sk" :
	$llang = "slovenský";
break;
case "fi" :
	$llang = "suomalainen";
break;
case "sv" :
	$llang = "svensk";
break;
case "th" :
	$llang = "thai";
break;
case "tr" :
	$llang = "türk";
break;
case "ua" :
	$llang = "ukrainian";
break;
case "vi" :
	$llang = "việt";
break;
default:
    $llang = "english";
    $lang_warning = "eyeOS Warning";
    $lang_notrun = "Your web sever configuration does not allow eyeOS to run.";
    $lang_phpini = "This is due to the parameter '<strong>safe_mode</strong>' is set to '<strong>on</strong>' in your '<strong>php.ini</strong>' file. If you have access to that file, you could change 'safe_mode' to 'Off' and restart your web server in order to use eyeOS.";
    $lang_beyondcontrol = "We apologize for this situation which is beyond our control.";
    $lang_enterall = "Please enter all information requested";
    $lang_pwdnotmatch = "Passwords do not match, please reenter";
    $lang_nocreatefile = "Failed to create file %1";
    $lang_nocreatedir = "Failed to create directory %0";
    $lang_rootuserval = "%0 eyeOS root user email validation : %1";
    $lang_failedsendmail = "Sending of validation email failed";
    $lang_statsdirnot = "Statistics directory, %0, not created or not writeable";
    $lang_notwritesys = "Cannot write to system definition file";
    $lang_title = "eyeOS ".OSVERSION." Installation Script";
    $lang_setpermissions = "Please set permissions of 0777 on the following directories : ";
    $lang_usereload = "Then use your browser reload button to retry the installation";
    $lang_back = "Back to Installation parameters";
    $lang_sysnotwrite = "The system definition file sysdefs.php is not writeable. In order to change these parameters you will need to change the permissions on that file to allow PHP to write to it. You may reset the permissions after installation completes";
    $lang_setvalues = "Set security values";
    $lang_welcome = "Welcome to eyeOS installation script.";
    $lang_text = "Before using your new eyeOS system, you need specify some system parameters.<br/>The install process will be completed in a minute!";
    $lang_advanced = "Advanced security parameters";
    $lang_specifyname = "Specify a name for your new eyeOS system :";
    $lang_deflanguage = "Choose the default language :";
    $lang_email = "Root user email address (see note below) :";
    $lang_specifypwd = "Specify the password for user \"%0\", the root user :";
    $lang_retypepwd = "Retype root user password :";
    $lang_install = "Install eyeOS >>";
    $lang_validation = "Email address is needed only if you intend to enable email validation of user created accounts. <br/>This feature is enabled if the root user email address is validated and <br/>if the file validate.txt is present in the login directory.";
break;
}
?>