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

    include "installlang.php";
    $langname = rawurldecode($_REQUEST['ll']);

if (strtolower(ini_get('safe_mode')) == 'on' || ini_get('safe_mode') == 1) {
      echo "
      <html>
      <head>
         <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
         <link rel='stylesheet' href='".CSSDIR."style.css' type='text/css'>
         <link rel='icon' href='".CSSDIR."icon.gif' type='image/x-icon' />  
         <link rel='shortcut icon' href='".CSSDIR."icon.gif' type='image/x-icon' />
         <title>eyeOS Install ".OSVERSION."</title>
      </head>
      <body>
    <div style='margin-left: 50px; margin-right: 50px; text-align: center'>
    <div style='color:#999; font-size: 85%;'>
        <a href='?ll=en'>english</a> - 
        <a href='?ll=de'>deutsch</a>
    </div>
         <div style='margin-left: 50px; margin-right: 50px; text-align: center'>
         <br /><h1>$lang_warning</h1>

         <br /> <span style='color:red;'><strong>$lang_notrun</strong><br /><br />
         <div align='center' style='margin-left: 100px; margin-right:100px;'> $lang_phpini <br /> <br />
         $lang_beyondcontrol</div></span>

      </body>
      </html>
"; 
	exit();
}
   if (!is_file ('sysdefs.php') && is_file ('funcions.php')) {
      header ('Location: ../index.php');
      exit;
   }

   if (!defined ('OSVERSION')) include_once 'sysdefs.php';  // if not autoprepended

   define ('USRDIR', kw(ROOTUSR));
   define ('HOMEDIR', kw(ROOTUSR));

   if (is_file (USRDIR.ROOTUSR.'/'.USRINFO) && is_file (SYSINFO)) {
      include 'index.php';
      exit;
   }

   if (!defined ('DEBUG')) {
     define ('DEBUG', !empty ($_REQUEST['debug']) ? $_REQUEST['debug'] : 0);
     error_reporting (DEBUG ? E_ALL : 0);
   }

   $sysdefs = file_get_contents ('sysdefs.php');
   $md5sysdefs = md5 ($sysdefs);
   if (preg_match ('!^//>>(.*?)$!m', $sysdefs, $sysvars))
      $sysvars = explode (',', $sysvars[1]);

   switch (@$_REQUEST['mode']) {
   case "installing":
      if (empty($_REQUEST['systemname']) || empty($_REQUEST['langselected']) || empty($_REQUEST['rpw1']) || empty($_REQUEST['rpw2']))
         $msg = $lang_enterall;
      elseif ($_REQUEST['rpw1'] != $_REQUEST['rpw2'])
         $msg = $lang_pwdnotmatch;
      else 
         while (1) {
            createXML (SYSINFO, 'eyeOS', array (
	       'hostname' => $_REQUEST['systemname'],
	       'lang' => $_REQUEST['langselected'],
	       'os' => 'eyeOS',
	       'ver' => OSVERSION
	    )); 	      

	    if (!is_file (SYSINFO)) {
	       $msg = _L($lang_nocreatefile, SYSINFO); 
	       break;
	    }
	    
/* Build list of available apps 	 
	    $applist = array ();
            foreach (explode (',', APPDIRS) as $appdir)
               if ($adir = @opendir ($appdir = filename ($appdir)))
	          while ($app = readdir ($adir))
                     if (($app{0} != '.') && is_dir ($appdir.$app) && file_exists ($appdir."$app/".APP_ICON) && 
                        file_exists ($appdir."$app/".APP_INFO) && file_exists ($appdir."$app/".APP_CODE))
		        $applist[] = $appdir.$app;
*/
            @mkdir (USRDIR);
            @chmod (USRDIR, 0777);
            @mkdir (USRDIR.ROOTUSR);
            @chmod (USRDIR.ROOTUSR, 0777);
	    if (!file_exists (USRDIR.ROOTUSR)) {
	       $msg = _L($lang_nocreatedir, USRDIR.ROOTUSR); 
	       break;
	    }

	    createXML (USRDIR.ROOTUSR.'/'.USRINFO, ROOTUSR, array (
	       'hostname' => $_REQUEST['systemname'],
	       'pwd' => md5 (unhtmlentities($_REQUEST['rpw1'])),
	       'real' => 'root',
	       'usr' => 'usr',
	       'wllp' => SYSDIR."themes/default/eyeos.jpg",
	       'theme' => 'default',
	       'lang' => $_REQUEST['langselected'],
	       'email' => $_REQUEST['email'],
	       'run_once' => 'apps/eyeWelcome.eyeapp',
	       'apps' => 'apps/eyeHome.eyeapp,apps/eyeEdit.eyeapp,apps/eyeCalendar.eyeapp,apps/eyePhones.eyeapp,apps/eyeCalc.eyeapp,apps/eyeMessages.eyeapp,apps/eyeBoard.eyeapp,apps/eyeNav.eyeapp,apps/eyeRSS.eyeapp,apps/eyeCommand.eyeapp,apps/eyeOptions.eyeapp,apps/eyeInfo.eyeapp,apps/eyeApps.eyeapp'
//	     'apps' => implode (',', $applist)
// or add eyeApps to run_once list ??
	    ));

	    if (!file_exists (USRDIR.ROOTUSR.'/'.USRINFO)) {
	       $msg = _L($lang_nocreatefile, USRDIR.ROOTUSR.'/'.USRINFO); 
	       break;
	    }
      @mkdir (HOMEDIR);
      @chmod (HOMEDIR, 0777);
      @mkdir (HOMEDIR.ROOTUSR);
      @chmod (HOMEDIR.ROOTUSR, 0777);
	    if (!file_exists (HOMEDIR.ROOTUSR)) {
	       $msg = _L($lang_nocreatedir, HOMEDIR.ROOTUSR); 
	       break;
	    }

      if (!empty ($_REQUEST['email'])) {
        $key = sprintf ("%X%08X", rand(), time());  

        if (!mail ($_REQUEST['email'], $_REQUEST['systemname'], 
          _L($lang_rootuserval, 
          $_REQUEST['systemname'], 
          "http://$_SERVER[SERVER_NAME]/".trim($_SERVER['REQUEST_URI'], '/')."?validate=$key&newuser=".ROOTUSR),
          "From: $_REQUEST[email]\r\nReply-To: $_REQUEST[email]\r\nX-Mailer: PHP/" . phpversion())) {
          $mag = $lang_failedsendmail;
          break;
        }

        if (!parse_update (USRDIR.ROOTUSR.'/'.USRINFO, 'validate', $key))
          log_error ('parse_update ROOT USRINFO failed');
      }
      
	    $_REQUEST['usr'] = ROOTUSR;
	    $_REQUEST['pwd'] = $_REQUEST['rpw1'];
	    include 'index.php';
	    exit;
	 }
      break;
      
   case 'setsecurity' :
      $msg = '';
      if (!empty ($sysvars) && ($_REQUEST['id'] == $md5sysdefs)) {
        foreach ($sysvars as $v)
          if (!empty ($_REQUEST[$v = strtoupper (trim($v))])) {
	          $n = $_REQUEST[$v];
          
          if ((substr ($v, -3) == 'DIR') && (substr ($n, -1) != '/'))
	          $n .= '/';

          switch ($v) {  
          case 'STATSDIR':
            if ($n) {   
              if (!is_dir($n))
                @mkdir ($n);
              if (!is_writable ($n))
        	      $msg = _L($lang_statsdirnot, $n);
            }
            break;

         case 'CREATE_ACCOUNTS':
         case 'SHOW_USER_LISTS':
            $n = (strtolower ($n) == 'yes') ? 'yes' : 'no';
            break;
          }   
          
         $sysdefs = preg_replace ( "!(define\s*\\(\'$v\',\s*)\'.*?\'(\);)!", "\$1'$n'\$2", $sysdefs);
	    }
	    
      if (!$msg && $fd = fopen ('sysdefs.php', 'w')) {
  	    fwrite ($fd, $sysdefs);
	      fclose ($fd);
      
        header ('Location: index.php');
        exit;
      }
	  else
	     $msg = $lang_notwritesys;
      }
   }

   echo "
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <link rel='stylesheet' href='".CSSDIR."style.css' type='text/css'>
    <link rel='icon' href='".CSSDIR."icon.gif' type='image/x-icon' />  
    <link rel='shortcut icon' href='".CSSDIR."icon.gif' type='image/x-icon' />
    <title>eyeOS Install ".OSVERSION."</title>
  </head>
  <body>
    <div style='margin-left: 50px; margin-right: 50px; text-align: center'>
    <div style='color:#999; font-size: 85%;'>
        <a href='?ll=en'>english</a> - 
        <a href='?ll=de'>deutsch</a>
    </div>
      <div class='titoltaronja'>$lang_title</div>";
   if (!empty ($msg))      
      echo "
      <br /><h2 style='color:red'>$msg</h2><br />";

   foreach (array (USRBASE, HOMEBASE, ETCDIR) as $d) {
      if (!file_exists ($d)) {
         @mkdir ($d);
         @chmod ($d, 0777);
	 }
      if (is_dir($d)) {
         @chmod ($d, 0777);	      
         if (!is_writable ($d))
   	    $setwritable[] = $d;
      }
   }

   if (@count ($setwritable)) {
      echo "
      <div align='center'>";
      if (@count ($setwritable))
         echo "
        <span style='color:red;'>$lang_setpermissions
	  <br />
	  <ul>
	    <li>". implode ('</li><li>', $setwritable)."</li>
          </ul>
        </span>";
      
      echo "$lang_usereload</div>";
   } else {
 
      if (!empty ($sysvars)) {
         echo "   
       <div align='center' id='Security_params' style='display:none'>
	 <button onclick='
	   document.getElementById(\"Security_params\").style.display=\"none\";
	   document.getElementById(\"Install_params\").style.display=\"block\";' >
	   $lang_back
	 </button>
	 <br /><br />";
	 
	 if (!is_writeable ('sysdefs.php'))
	    echo "
         <p style='color:red'>$lang_sysnotwrite</p>";
	 
	 echo "
         <form action='index.php'>
	   <input type='hidden' name='mode' value='setsecurity' />
	   <input type='hidden' name='id' value='$md5sysdefs' /> 
           <table width='80%' align='center'>";
      
         foreach ($sysvars as $v) {
	    $v = strtoupper (trim ($v));
 	    if (preg_match ("!define\s*\\('$v',\s*'(.*?)'.*?//\s*(.*)?\$!m", $sysdefs, $svar))  
            echo "
           <tr>
	     <td>$v</td>
	     <td><input type='text' name='$v' value='${svar[1]}' /></td>
	     <td>${svar[2]}</td>
	   </tr>";	 
         }
      
	 if (is_writeable ('sysdefs.php'))
            echo "
	   <br />
	   <tr>
	     <td colspan='3' align='right'> 
	       <br />
	       <button type='submit'>$lang_setvalues</button>
             </td>
	   </tr>";
	   
	 echo "  
           </table>
	 </form>
       </div>";
      }

      echo "	
        <div align='center' id='Install_params' style='display:block'>
        <p>$lang_welcome<br/>$lang_text<br/>
        </p>
        <br/>";
	
      if (!empty ($sysvars)) 	
      	 echo "
	  <button onclick='
	    document.getElementById(\"Security_params\").style.display=\"block\";
	    document.getElementById(\"Install_params\").style.display=\"none\";' >
	    $lang_advanced
	  </button>
	 <br /> <br />";
      echo "	 
      <form 
         action='index.php' 
         method='post'>
	<input type=hidden name='mode' value='installing'> 
          <table border='0' width='80%'>
            <tr>
	      <td>$lang_specifyname</td>
	      <td>
	        <input 
		   type='text' 
		   name='systemname' 
		   size='30' 
		   maxlenght='30' 
		   value='".(empty ($_REQUEST['systemname']) ? 'eyeOS' : $_REQUEST['systemname'])."' />
	      </td>
            </tr>
            <tr>
	      <td>$lang_deflanguage</td>
	      <td>
	        <select name='langselected'>";
      preg_match_all ("!^'(.+?)'\s*\=\>\s*array\s*\(!m", file_get_contents (SYSDIR.LANGFILE), $langs);
      foreach ($langs[1] as $l)
         echo "<option".($l == $llang ? ' selected' : '').">$l</option>";
      echo "		  
	        </select>
	      </td>
            </tr>
            <tr>
	      <td>$lang_email</td>
	      <td>
	        <input type='input' name='email' size='30' maxlenght='30' />
	      </td>
            </tr>
            <tr>
	      <td>"._L($lang_specifypwd, ROOTUSR)."</td>
	      <td>
	        <input type='password' name='rpw1' size='30' maxlenght='30' />
	      </td>
            </tr>
            <tr>
	      <td>$lang_retypepwd</td>
	      <td>
	        <input type='password' name='rpw2' size='30' maxlenght='30' />
	      </td>
            </tr>
            <tr>
              <td colspan='2' align='right'>
	        <br />
	        <button type='submit'>$lang_install</button>
	      </td>
            </tr>
          </table>
        </form>
        <p> $lang_validation </p>
      </div>
    </div>
  </body>
</html>";
   }
   exit;
?>
