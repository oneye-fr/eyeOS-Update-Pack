<?PHP
/*                              eyeOS project
                     Internet Based Operating System
                               Version 0.9
                     www.eyeOS.org - www.eyeOS.info
       -----------------------------------------------------------------
                  Pau Garcia-Mila Pujol - Hans B. Pufal
       -----------------------------------------------------------------
          eyeOS is released under the GNU General Public License - GPL
               provided with this release in DOCS/gpl-license.txt
                   or via web at www.gnu.org/licenses/gpl.txt

         Copyright 2005-2006 Pau Garcia-Mila Pujol (team@eyeos.org)

          To help continued development please consider a donation at
            http://sourceforge.net/donate/index.php?group_id=145027         */

// The following may be modified for security reasons, but ONLY before installation   
// they are modifiable from the advanced security panel in the installation script

//>>  SYSINFO, BBOARD, ROOTUSR, USRINFO, USRBASE, HOMEBASE, MSGDIR, NOTEDIR, SYSAPPS, THEMESDIR, STATSDIR, CREATE_ACCOUNTS, USER_QUOTA

define ('SYSINFO', 'etc/system.php');  // System parameter (path & file)
define ('BBOARD', 'etc/taulell.php');  // eyeBoard (path & file)

define ('ETCDIR', dirname (SYSINFO).'/');

define ('ROOTUSR', 'root');             // Root user (text)
define ('USRINFO', 'usrinfo.php');      // User parameter (file)
define ('USRBASE', 'etc/users/');       // Users directory (path)
define ('HOMEBASE', 'etc/files/');      // Homes directory (path)
define ('MSGDIR', 'Inbox/');            // Messages directory (path)
define ('NOTEDIR', 'eyeEdit/');         // Notes directory (path)
define ('SYSAPPS', 'etc/apps/');       // System-wide eyeApps directory (path)
define ('THEMESDIR', 'etc/themes/');   // Themes directory (path)
define ('STATSDIR', '');                // Statistics directory (suggestion = "etc/stats/" / blank to disable)
define ('CREATE_ACCOUNTS', 'yes');      // Allow account creation (yes / no)
define ('USER_QUOTA', '');              // Max quota per user (in MB / blank to disable)

// The following may be changed even after system installation

define ('APP_INSTALLATION', 1);         // eyeApp installation from 0=nobody, 1=root, 2=all

define ('USEDEMO', 'no');                // Use eyeOS as Demo (yes / no)
define ('DEMOUSR', '');      // Demo user (text)
define ('DEMOPWD', '');              // Demo password (text)

// Do not make changes after here without due consideration of the consequences

   define ('OLDHOMEDIR', 'home/');      // Old directory for all homes (path)
   define ('OLDUSRDIR', 'usr/');        // Old directory for all users (path)

   define ('OSVERSION', '0.9.3-5b');    // eyeOS version

   define ('SYSDIR', 'system/');        // System directory (path)
   define ('CSSDIR', SYSDIR.'install/');
   define ('SCRIPTDIR', SYSDIR.'scripts/');
   define ('GFXDIR', SYSDIR.'themes/default/btn/');
   define ('CONFIG', SYSDIR.'config.php');

   define ('USRAPPS', '~usr/apps/');
   define ('APPDIRS', USRAPPS.','.SYSAPPS.',apps/');    // Comma separated list of app dirs
   define ('APPMANAGER', 'apps/eyeApps.eyeapp'); 
   define ('APPSKIN', 'gfx/');
   
   define ('DEFAULTLANG', 'english');
   define ('LANGFILE', 'lang.php');     // Languages (file)

   define ('MAXICONS', 15);             // Number of icons allowed in user dock, suggest 15 (for a 1024x768 resolution)

   define ('APP_CODE', 'aplic.php');    // Application code file
   define ('APP_ICON', 'ico_c.png');    // Application icon (not running)
   define ('APP_RUNICON', 'ico_b.png'); // Application icon when running
   define ('APP_INFO', 'propietats.xml');   // Application info file
   
// For the windowing system,
   # default heights and widths
   define ('WINDOW_HEIGHT', 200);
   define ('WINDOW_WIDTH', 350);
   # Non fixed window position start and inc 
   define ('WINDOW_START', 60);
   define ('WINDOW_INC', 40);
   
   define ('SYSFMT_DATE', 'd/m/Y');
   define ('SYSFMT_TIME', 'H:i');
     
   define ('MACRO_OPEN', '/!');
   
   define ('MSGSRCS', '~usr/'.MSGDIR);

   require_once SYSDIR.'funcions.php';
   foreach ($_REQUEST as $k => $v) $_REQUEST[$k] = cleanvar($v);
   foreach ($_POST as $k => $v) $_POST[$k] = cleanvar($v);
   foreach ($_GET as $k => $v) $_GET[$k] = cleanvar($v);

   session_start ();
   
  if (false !== strpos (strtoupper (OSVERSION), 'X')) { 
    @define ('DEBUG', $_SESSION['debug'] = !empty ($_REQUEST['debug']) ? 
      $_REQUEST['debug'] : (!empty ($_SESSION['sysinfo']['debug']) ? 
      $_SESSION['sysinfo']['debug'] : @$_SESSION['debug']));
    error_reporting (E_ALL);
  } else {
    @define ('DEBUG', 0);
    error_reporting (0);
  }
  
  header ('Content-Type: text/html; charset=UTF-8'); //if not set
  ini_set('session.cache_expire',     2000000);
  ini_set('session.cookie_lifetime',  2000000);
  ini_set('session.gc_maxlifetime',   200000);
?>
