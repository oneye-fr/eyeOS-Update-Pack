<?php
if (!defined('USR')) return;
/*
eyeOptions.eyeapp
-------------
Version: 1.0.0

Developers:
-----------
Pau Garcia-Mila
Hans B. Pufal
*/

   global $Message;
   $Message = '';

   $crear = cls(@$_REQUEST['crear']);
   $esborrarusr = cls(@$_REQUEST['esborrarusr']);
   $borrarfondo = cls(@$_REQUEST['borrarfondo']);
   $acrearusr = cls(@$_REQUEST['acrearusr']);
   $acrearpwd = @$_REQUEST['acrearpwd'];
   $acrearpwd2 = @$_REQUEST['acrearpwd2'];
   $acrearreal = cls(@$_REQUEST['acrearreal']);
   $aborrarusr = cls(@$_REQUEST['aborrarusr']);
   $aborrarusr2 = cls(@$_REQUEST['aborrarusr2']);
   $nounom = cls(@$_REQUEST['nounom']);
   $usracanviar = cls(@$_REQUEST['usracanviar']);

//RESTORE WALLPAPER
   if (isset ($_REQUEST["borrarfondo"])) {
      parse_update (USRDIR."$usr/".USRINFO, 'wllp', $_SESSION['fondoescollit'] = SYSDIR."themes/default/eyeos.jpg");   
      $_SESSION['fondoescollit'] = SYSDIR."themes/default/eyeos.jpg";
      if (file_exists(USRDIR."$usr/wllp.jpg")) unlink(USRDIR."$usr/wllp.jpg");
      msg(_L('Wallpaper restored'));
   }

//CHANGE WALLPAPER
   if (!empty ($_REQUEST['canviarfondo'])) {
      $wllpfname = basename($_FILES["file"]["name"]);
      $ext = strtolower(substr(strrchr($wllpfname, "."), 1));
      $image_ext = Array("png","jpg","jpeg","bmp","gif","tiff","svg");
      if (isset ($_REQUEST["files"]) && (in_array($ext, $image_ext)) && move_uploaded_file ($_FILES["file"]["tmp_name"], USRDIR."$usr/wllp.jpg")) {
         parse_update (USRDIR."$usr/".USRINFO, 'wllp', USRDIR."$usr/wllp.jpg");
         $_SESSION['fondoescollit'] = USRDIR."$usr/wllp.jpg";
         msg(_L('Wallpaper succesfully changed'));
      }
   }

   if (isset ($_REQUEST["borrarfondo"]) || !empty ($_REQUEST['canviarfondo'])) {
      echo "
      <script>
         document.body.style.background = 'transparent url(${_SESSION['fondoescollit']}) no-repeat fixed center center';
      </script>";
   }

//CHANGE THEME
   if (!empty ($_REQUEST['newtheme'])) {
      if (file_exists(THEMESDIR.basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg")) {
         parse_update (USRDIR."$usr/".USRINFO, 'wllp', THEMESDIR.basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg");
         $_SESSION['fondoescollit'] = THEMESDIR.basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg";
  }

      if (file_exists(SYSDIR."themes/".basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg")) {
         parse_update (USRDIR."$usr/".USRINFO, 'wllp', SYSDIR."themes/".basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg");
         $_SESSION['fondoescollit'] = SYSDIR."themes/".basename(strip_tags($_REQUEST['newtheme']))."/eyeos.jpg";
  }

      if (file_exists(SYSDIR."themes/".basename(strip_tags($_REQUEST['newtheme']))) || file_exists(THEMESDIR.basename(strip_tags($_REQUEST['newtheme'])))) {
         parse_update (USRDIR."$usr/".USRINFO, 'theme', basename(strip_tags($_REQUEST['newtheme'])));
         $_SESSION['usrinfo']["theme"] = basename(strip_tags($_REQUEST['newtheme']));
         msg(_L('Theme succesfully changed'));
      echo "
      <script>
       window.location=\"desktop.php\";
      </script>";

      }
   }


//CHANGE HOSTNAME
   if ($usr == ROOTUSR) {
      if (!empty ($_REQUEST['redefhostnou'])) {
        parse_update (SYSINFO, 'hostname', cls ($_REQUEST['redefhostnou']));
	msg (_L('Hostname updated succesfully'));
      }
 

   }

// CREATE NEW USER
if(isset ($_REQUEST['acrearusr']) && isset ($_REQUEST['acrearpwd'])) {

      if ($_REQUEST['acrearpwd'] == $_REQUEST['acrearpwd2']) {
			if(is_dir(kw($acrearusr).$acrearusr)) { msg("User already exists"); }
   elseif ($usr == ROOTUSR && $acrearusr <> "") {
			$acrearreal = cls($_REQUEST['acrearreal']);
			$acrearpwd = md5(unhtmlentities($acrearpwd));
			if (!is_dir(kw($acrearusr))) mkdir (kw($acrearusr),0777);
			$dirusers = kw($acrearusr).$acrearusr."/";
			@mkdir($dirusers, 0777);
			createXML ($dirusers . USRINFO, "eyeOSuser", array (
	'lang' => "english",
	'pwd' => $acrearpwd,
	'real' => $acrearreal,
	'usr' => $acrearusr,
	'wllp' => SYSDIR."themes/default/eyeos.jpg",
	'theme' => 'default',
	'run_once' => 'apps/eyeWelcome.eyeapp',
	'apps' => 'apps/eyeHome.eyeapp,apps/eyeEdit.eyeapp,apps/eyeCalendar.eyeapp,apps/eyePhones.eyeapp,apps/eyeCalc.eyeapp,apps/eyeMessages.eyeapp,apps/eyeBoard.eyeapp,apps/eyeNav.eyeapp,apps/eyeRSS.eyeapp,apps/eyeOptions.eyeapp,apps/eyeInfo.eyeapp,apps/eyeApps.eyeapp'
	 ));
         msg(_L('New user created'));
		}
	}
}

//ERASE AN USER
if(isset ($_REQUEST['aborrarusr'])) { 
   $aborrarusr = cls($_REQUEST['aborrarusr']);
   $pwdactual = md5($_REQUEST['pwdactual']);
   $fpwdroot=kw(ROOTUSR).ROOTUSR."/".USRINFO;
	$rootxml = parse_info ($fpwdroot);
	$pwdxcomparar = $rootxml['pwd'];
      if ($pwdactual == $pwdxcomparar){
         if ($usr == ROOTUSR && $aborrarusr <> ROOTUSR && $aborrarusr <> "") {
            if (is_file(kw($aborrarusr). "$aborrarusr/".USRINFO) && file_exists(kw($aborrarusr). "$aborrarusr/".USRINFO)) {
				esborradir (kw($aborrarusr). $aborrarusr . "/");
				esborradir (mh($aborrarusr). $aborrarusr . "/");
	       	msg(_L('User removed succesfully'));
	    		}
         }
   }
}
//CHANGE PASSWORD
   $canviarusr = cls(@$_REQUEST['canviarusr']);
   if (isset ($canviarusr) && !empty ($_REQUEST['noupwd'])) {
		if ((md5($_REQUEST['pwdactual']) == $_SESSION['usrinfo']['pwd']) && (($usr == ROOTUSR) || ($canviarusr == $usr))) {
         if (($noupwd = md5 ($_REQUEST['noupwd'])) == md5 ($_REQUEST['noupwd2'])) {
	       $_SESSION['usrinfo']['pwd'] = $noupwd;
 	    parse_update (USRDIR."$canviarusr/".USRINFO, 'pwd', $noupwd);
            msg (_L('Password succesfully set')); 
	 } else  
	   msg (_L('The passwords are not equal'));
      } else 
	 msg (_L('Wrong password'));
   }

   $usrselect = "<input type='text' name='canviarusr' size=28' /><br />";
   $usrremove = "<input type='text' name='aborrarusr' size=28' /><br />";




//CHANGE WALLPAPER FORM

   echo "<div class='titoltaronja'>"._L('Look and feel')." </div>
     <h2 style='text-align:center;'>"._L('Change wallpaper')."</h2>
     <form action='desktop.php?a=$eyeapp&canviarfondo=si&canviantfons=2' enctype='multipart/form-data' method='post'>
     <div align='center'>
     <strong>"._L('New wallpaper').":</strong>
     <input name='file' type='file' size='30'><br />
     <input name='files' name='Submit' type='submit' value='"._L('Change wallpaper')."' />
     </form>
     <form action='desktop.php?a=fns_eyeOptions&borrarfondo=si&canviantfons=1' method='post'>
     <input name='files' name='Submit' type='submit' value='"._L('Restore eyeOS wallpaper')."'>
     </form>
     </div>
      <hr width='85%' />";
//CHANGE THEME FORM
echo "<h2 style='text-align:center;'>"._L('Change theme')."</h2>
<div align='center'>
";
   if (!is_dir(THEMESDIR)) mkdir (THEMESDIR, 0777);
   $actualxml =  parse_info (USRDIR."$usr/".USRINFO);
   $themeselect = "<form action='desktop.php?a=$eyeapp' method='post'><table border='0'>";

   $themes = opendir (SYSDIR."themes/");
   while ($the = readdir ($themes)) {
      if (is_dir (SYSDIR."themes/"."$the/") && $the != "." && $the != "..") {
         $themeselect .= "<tr><td><input type='radio' name='newtheme'";
         if ($actualxml["theme"] == $the) $themeselect .=" CHECKED ";
         $themeselect .= "VALUE='$the'></td><td>$the</td><td><img src='".SYSDIR."themes/$the/thumb.png'></td></tr>";
	}
      }
   closedir ($themes);

   $themes = opendir (THEMESDIR);
   while ($the = readdir ($themes)) {
      if (is_dir (THEMESDIR."$the/") && $the != "." && $the != "..") {
         $themeselect .= "<tr><td><input type='radio' name='newtheme'";
         if ($actualxml["theme"] == $the) $themeselect .=" CHECKED ";
         $themeselect .= "VALUE='$the'></td><td>$the</td><td><img src='".THEMESDIR."$the/thumb.png'> </td></tr>";
	}
      }
   closedir ($themes);
   $themeselect .= "</table><br /><INPUT name='submit' TYPE='submit' VALUE='"._L('Change theme')."'></form></div><hr width='85%' />";

echo $themeselect;
echo "<div class='titoltaronja'>"._L('System options')." </div>";
   echo"
     <h2 style='text-align:center;'>"._L('Change password')."</h2>
     <FORM ACTION='desktop.php?a=$eyeapp' METHOD='post'>
     <table width='80%' align='center'>" .
     (($usr == ROOTUSR) ?
        "
           <tr><td><strong>"._L('Select user').":</strong></td>
           <td>$usrselect</td></tr>
	   <tr><td><strong>"._L('Actual root\'s password').":</strong></td>"
      : "	   
           <tr><td><input type='hidden' name='canviarusr' value='".USR."' />
           <strong>"._L('Actual password').":</strong></td>").
        "	   
        <td><INPUT TYPE='password' NAME='pwdactual' SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('New password').":</strong></td>
        <td><INPUT TYPE='password' NAME='noupwd' SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('Retype password').":</strong></td>
        <td><INPUT TYPE='password' NAME='noupwd2' SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td colspan='2' align='right'><INPUT name='submit' TYPE='submit' VALUE='"._L('Change password')."'></td></tr>
      </table>	
      </FORM>
      <hr width='85%' />";

//FORMS ONLY FOR ROOT
if ($usr == ROOTUSR) {

echo"
        <h2 style='text-align:center;'>"._L('New hostname')."</h2>
        <FORM ACTION='desktop.php?a=$eyeapp' METHOD='post'>
	<table align='center' width='80%'>
        <tr><td><strong>"._L('New hostname').":</strong></td>
        <td><INPUT TYPE='text' NAME='redefhostnou' SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td colspan='2' align=right><INPUT name='submit' TYPE='submit' VALUE='"._L('Change hostname')."' /></td></tr>
      </table>	
      </FORM>
      <hr width='85%' />";

echo "
<h2>"._L('New user')."</h2>
     <table width='80%' align='center'>
<FORM ACTION=\"desktop.php?a=$eyeapp\" METHOD=\"post\">
        <tr><td><strong>"._L('User name').":</strong></td>
        <td><INPUT TYPE=\"text\" NAME=\"acrearusr\" SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('Password').":</strong></td>
        <td><INPUT TYPE=\"password\" NAME=\"acrearpwd\" SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('Retype Password').":</strong></td>
        <td><INPUT TYPE=\"password\" NAME=\"acrearpwd2\" SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('Real name').":</strong></td>
        <td><INPUT TYPE=\"text\" NAME=\"acrearreal\" SIZE=28 MAXLENGTH=255 /></td></tr>

        <tr><td colspan='2' align='right'><INPUT name='submit' TYPE='submit' VALUE='"._L('Create user')."'></td></tr>
</FORM>
      </table>	
<hr width='85%' />";

//ERASE AN USER
echo"
<h2>"._L('Delete user')."</h2>
     <table width='80%' align='center'>
<FORM ACTION=\"desktop.php?a=$eyeapp\" METHOD=\"post\">
        <tr><td><strong>"._L('Root\'s password').":</strong></td>
        <td><INPUT TYPE=\"password\" NAME=\"pwdactual\" SIZE=28 MAXLENGTH=20 /></td></tr>
        <tr><td><strong>"._L('Select user').":</strong></td>
        <td>$usrremove</td></tr>
        <tr><td colspan='2' align='right'><INPUT name='submit' TYPE='submit' VALUE='"._L('Delete')."'></td></tr>
</FORM>
      </table>	";
}
?>
