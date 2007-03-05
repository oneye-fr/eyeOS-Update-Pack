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

 if (!defined ('OSVERSION')) require_once 'sysdefs.php';  // if not autoprepended
include "mobilelang.php";
   $langname = rawurldecode($_REQUEST['ll']);
  if ((!is_file (kw(ROOTUSR).ROOTUSR.'/'.USRINFO) && !is_file (OLDUSRDIR.ROOTUSR.'/'.USRINFO)) || !is_file (SYSINFO)) {
    @session_destroy ();
    include SYSDIR.'install.php';
    exit ;
  }

echo '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html lang="es" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>eyeOS Mobile</title>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
</head>

<body>
';

  if (
     !isset ($_SESSION['sysinfo']) 
     || isset ($_REQUEST['exit']) 
     || ($_SESSION['remote_addr'] != $_SERVER['REMOTE_ADDR']) 
     || !isset ($_SESSION['usr'])
    ) {

  session_destroy ();
  echo '  
<img border="0" alt="eyeOS Mobile" title="eyeOS Mobile" src="'.findGraphic('mobile','mobile.gif').'"><br />
  <div style="padding: 4px; background-color: #f5fde2;">
    <form name="loginform" action="index.php" method="post"> 
      '.$lang_username.'<br />
      <input type="text" name="usr" maxlength="80" size="18" /><br />
      '.$lang_password.'<br />
      <input type="password" name="pwd" maxlength="80" size="18" /><br />
      <input type="submit" name="submit" value="'.$lang_signin.'" />
      <input type="hidden" name="mobile" value="yes" />
    </form>
  </div>
  <small><a href="index.php?ll='.$lang.'">'.$lang_desktopver.'</a> - <a href="http://eyeos.org/mobile">'.$lang_whatis.'</a><br /><a href="http://eyeos.org">'.$lang_theproject.'</a><br /><br />
<a href="?ll=ar">arabic</a><br />
<a href="?ll=ms">bahasa melayu</a><br />
<a href="?ll=bn">bangla</a><br />
<a href="?ll=pt_BR">brasileiro/português</a><br />
<a href="?ll=bg">bulgarian</a><br />
<a href="?ll=ca">català</a><br />
<a href="?ll=cs">český</a><br />
<a href="?ll=zh">chinese</a><br />
<a href="?ll=hr">croatian</a><br />
<a href="?ll=da">dansk</a><br />
<a href="?ll=de">deutsch</a><br />
<a href="?ll=en">english</a><br />
<a href="?ll=es">español</a><br />
<a href="?ll=eu">euskara</a><br />
<a href="?ll=fr">français</a><br />
<a href="?ll=gl">galego</a><br />
<a href="?ll=el">greek</a><br />
<a href="?ll=it">italiano</a><br />
<a href="?ll=ja">japanese</a><br />
<a href="?ll=ko">korean</a><br />
<a href="?ll=hu">magyar</a><br />
<a href="?ll=nl">nederlands</a><br />
<a href="?ll=no">norsk</a><br />
<a href="?ll=ir">persian</a><br />
<a href="?ll=pl">polski</a><br />
<a href="?ll=pt">português</a><br />
<a href="?ll=ro">românesc</a><br />
<a href="?ll=ru">russian</a><br />
<a href="?ll=sk">slovenský</a><br />
<a href="?ll=fi">suomalainen</a><br />
<a href="?ll=sv">svensk</a><br />
<a href="?ll=th">thai</a><br />
<a href="?ll=tr">türk</a><br />
<a href="?ll=ua">ukrainian</a><br />
<a href="?ll=vi">việt</a>
</small>
</body>
</html>
';
  exit;
  }

   if (!defined('USRDIR')) define ('USRDIR', kw($_SESSION['usr']));
   if (!defined('HOMEDIR')) define ('HOMEDIR', mh($_SESSION['usr']));
   define ('TOFFSET', $_SESSION['Toffset']);   
   define ('USR', $usr = $_SESSION['usr']);
   define ('RAX_SESSION', $_SESSION['rax']);
   unset ($_SESSION['reqkey']);

//START OF EYEOS MOBILE DESKTOP
if (!is_dir(HOMEDIR)) mkdir(HOMEDIR,0777);
if (!is_dir(HOMEDIR.USR."/")) mkdir(HOMEDIR.USR."/", 0777); 

  if (0 === strpos ($path = realpath (HOMEDIR.USR.'/'.trim(@$_REQUEST['path'])), realpath( HOMEDIR.USR.'/' ))) {
    $size = get_size(HOMEDIR.USR) + get_size(USRDIR.USR);
    $udir = substr ($path, strlen (realpath (HOMEDIR.USR)) + 1);
    if (substr($udir, -1) != "/" && !empty($udir)) $udir .= "/";
    $dir = HOMEDIR.USR."/".$udir;
  } else die();

// Upload a new file

 if (!empty($_FILES["file"]["name"])) {
  if ((USER_QUOTA && $size < USER_QUOTA) || !USER_QUOTA) {
      $name = uniqid(rand());
      $file = basename($_FILES["file"]["name"]);
      while (stristr($file, "php") !== false) {
          $file = str_ireplace("php", '', $file);
      }
      while (stristr($file, "eyeFile") !== false) {
          $file = str_ireplace("eyeFile", '', $file);
      }
      $file = basename(strip_tags(trim($file)));
      if (($file != "") && (substr($file, 0, 1) != ".")) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $name)) {
           createXML ($dir . $name . ".eyeFile", "eyeHome.eyeapp", array (
	          'author' => USR,
	          'filename' => $file,
	          'date' => time())
           );
        }
      }
    }
 }

//Create a directory
 if (isset($_REQUEST['dirname'])) {
  $dirname = basename(trim($_REQUEST['dirname']));
  if (eregi ("^[a-z0-9]+$", $dirname))
  {
  if (!empty($dirname) && !file_exists($dir . $dirname)) {
   if(mkdir($dir . $dirname, 0777));
   }
  }
 }
 
switch (@strtolower ($_REQUEST['type'])) {
case 'remove':     //Delete a file
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(basename($_REQUEST['file']));
  $trashdir = USRDIR.USR."/Trash/";
  if (!is_dir($trashdir)) mkdir($trashdir, 0777);
  if (is_file($dir . $file) && substr($file, -8) != ".eyeFile") {
   if (copy ($dir.$file, $trashdir.$file) && unlink($dir.$file)) {
     if (is_file($dir . $file.".eyeFile"))
     {
       copy ($dir.$file.".eyeFile", $trashdir.$file.".eyeFile");
       unlink($dir.$file.".eyeFile");
     }
    $msg = $lang_fileintrash;
   }
  }
 }
break;
case 'removedir':     //Delete a directory
 if (!empty($_REQUEST['dirname'])) {
  $dirname = basename(trim($_REQUEST['dirname']));
  $dirname = str_replace("./", "", $dirname);
  $dirname = str_replace(".", "", $dirname);
  if (!empty($dirname) && file_exists($dir . $dirname) && is_dir($dir . $dirname)) {
   if (@rmdir($dir . $dirname)) $msg = $lang_dirremoved; else $msg = $lang_dirnotempty;
  }
 }
break;
 default: break;

}

// Display the path
echo '  <img border="0" alt="eyeOS Mobile" title="eyeOS Mobile" src="'.findGraphic('mobile','mobile.gif').'"><br />';
echo "<div style='padding: 4px; background-color: #eeeeee;'>
  <strong><a href='m.php?ll=$langname'>$lang_home</a></strong>";

  $link = '';
  foreach (explode ('/' , substr($path, strlen(realpath(HOMEDIR.USR.'/')))) as $i)
    if (!empty($i)) echo " | <a href='m.php?path=".($link .= "$i/")."&ll=$langname'>$i</a>";

echo '</div><div style="padding: 4px; background-color: #ecf4fa;">';

// List files
if($open=opendir($dir)) {

 echo "<table border='0' cellpadding='3'>";

 $compte = 0;
 while ($f = readdir($open) ) {
  if ($f == ".." ||  $f == "." || substr($f, -8) == ".eyeFile") continue;
  $compte++;
  if(is_dir($dir.$f)) {
  echo "<tr><td style='text-align: center;' valign='center'><img border='0' src='".findGraphic('mobile','folder.gif')."'></td><td valign='center' align='left'><strong><a href='m.php?path=$udir$f/&ll=$langname'>$f</a></strong></td><td></td><td><a onclick='return estassegurpaperera()' href='?a=$eyeapp&type=removedir&dirname=$f&path=$udir&ll=$langname'><img border='0' src='".findGraphic('mobile','delete.gif')."' /></a></td></tr>";
  continue;
  }

  $size = round(filesize($dir . $f) / 1024);
  if (is_file($dir.$f.".eyeFile")) {
    $op = parse_info($dir.$f.".eyeFile");
    $mod = date("d/m/Y H:i", $op["date"] + TOFFSET);
    $fenc = $f;
    $f = $op["filename"];
  }
  else {
    $mod = date("d/m/Y H:i", filemtime($dir . $f) + TOFFSET);
    $fenc = rawurlencode($f);
  }

  $ext = strtolower(substr(strrchr($f, "."), 1));
  $icon = findGraphic('mobile','file.gif');
  if (in_array($ext, Array("png","jpg","jpeg","bmp","gif","tiff","svg"))) $icon = findGraphic('mobile','image.gif');
  if (in_array($ext, Array("html","htm","txt"))) $icon = findGraphic('mobile','text.gif');
  if (in_array($ext, Array("odt","sxw","doc","sdw"))) $icon = findGraphic('mobile','doc.gif');
  if (in_array($ext, Array("ods","sxc","xls","sdc"))) $icon = findGraphic('mobile','xls.gif');
  if (in_array($ext, Array("odp","sxi","ppt","sdd"))) $icon = findGraphic('mobile','ppt.gif');

  echo "<tr><td valign='center' style='text-align: center;'><img border='0' src='$icon' /></td><td valign='center' align='left'><a alt='$size KB - $mod' title='$size KB - $mod' href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>$f</a></td><td valign='center'><a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'><img alt=$lang_download border='0' src=".findGraphic('mobile','download.gif')." /></a></td><td valign='center'><a href='?a=$eyeapp&type=remove&file=$fenc&path=$udir&ll=$langname'><img alt=$lang_delete border='0' src='".findGraphic('mobile','delete.gif')."' /></a></td></tr>";
 }
echo "</table>";
closedir($open);
}
if ($compte == 0) $msg = $lang_dirempty;
echo "</div><div style='padding: 4px; background-color: #ffcccc;'>$msg";
echo '</div><div style="padding: 4px; background-color: #fff8ce;">
  <strong>'.$lang_uploadfile.' </strong><br />
  <form action="m.php?ll='.$langname.'" enctype="multipart/form-data" method="post">
    <input name="file" type="file">
    <input name="Submit" type="Submit" value="'.$lang_upload.'">
    <input type="hidden" name="path" value="'.$udir.'" />
  </form><br />
  <strong>'.$lang_createdir.' </strong><br />
  <form action="m.php?ll='.$langname.'" method="post">
    <input type="hidden" name="path" value="'.$udir.'" />
    <input type="text" name="dirname" maxlength="15" />
    <input name="Submit" type="Submit" value="'.$lang_create.'">  
  </form>';
echo '</div>
<small><a href="m.php?exit&ll='.$langname.'">'.$lang_signout.'</a> - <a href="desktop.php">'.$lang_desktopver.'</a><br /><br />
<a href="?ll=ar">arabic</a><br />
<a href="?ll=ms">bahasa melayu</a><br />
<a href="?ll=bn">bangla</a><br />
<a href="?ll=pt_BR">brasileiro/português</a><br />
<a href="?ll=bg">bulgarian</a><br />
<a href="?ll=ca">català</a><br />
<a href="?ll=cs">český</a><br />
<a href="?ll=zh">chinese</a><br />
<a href="?ll=hr">croatian</a><br />
<a href="?ll=da">dansk</a><br />
<a href="?ll=de">deutsch</a><br />
<a href="?ll=en">english</a><br />
<a href="?ll=es">español</a><br />
<a href="?ll=eu">euskara</a><br />
<a href="?ll=fr">français</a><br />
<a href="?ll=gl">galego</a><br />
<a href="?ll=el">greek</a><br />
<a href="?ll=it">italiano</a><br />
<a href="?ll=ja">japanese</a><br />
<a href="?ll=ko">korean</a><br />
<a href="?ll=hu">magyar</a><br />
<a href="?ll=nl">nederlands</a><br />
<a href="?ll=no">norsk</a><br />
<a href="?ll=ir">persian</a><br />
<a href="?ll=pl">polski</a><br />
<a href="?ll=pt">português</a><br />
<a href="?ll=ro">românesc</a><br />
<a href="?ll=ru">russian</a><br />
<a href="?ll=sk">slovenský</a><br />
<a href="?ll=fi">suomalainen</a><br />
<a href="?ll=sv">svensk</a><br />
<a href="?ll=th">thai</a><br />
<a href="?ll=tr">türk</a><br />
<a href="?ll=ua">ukrainian</a><br />
<a href="?ll=vi">việt</a>
</small>
</body>
</html>';
?>
