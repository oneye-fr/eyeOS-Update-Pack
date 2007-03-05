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
<img border="0" alt="eyeOS Mobile" title="eyeOS Mobile" src="'.findGraphic ('', 'mobile/logo.gif').'"><br />
  <div style="padding: 4px; background-color: #f5fde2;">
    <form name="loginform" action="index.php" method="post"> 
      User: <br />
      <input type="text" name="usr" maxlength="80" size="18" /><br />
      Password: <br />
      <input type="password" name="pwd" maxlength="80" size="18" /><br />
      <input type="submit" name="submit" value="Log In" />
      <input type="hidden" name="mobile" value="yes" />
    </form>
  </div>
  <small><a href="index.php">Desktop version</a> - <a href="http://eyeos.org/mobile">What is eyeOS?</a><br /><a href="http://eyeos.org">The eyeOS Project</a></small>
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


// Display the path
echo '  <img border="0" alt="eyeOS Mobile" title="eyeOS Mobile" src="'.findGraphic ('', 'mobile/logo.gif').'"><br />';
echo "<div style='padding: 4px; background-color: #eeeeee;'>
  <strong><a href='m.php'>"._L("My Home")."</a></strong>";

  $link = '';
  foreach (explode ('/' , substr($path, strlen(realpath(HOMEDIR.USR.'/')))) as $i)
    if (!empty($i)) echo " / <a href='m.php?path=".($link .= "$i/")."'>$i</a>";

echo '</div><div style="padding: 4px; background-color: #ecf4fa;"><br />';

// List files
if($open=opendir($dir)) {

 $compte = 0;
 while ($f = readdir($open) ) {
  if ($f == ".." ||  $f == "." || substr($f, -8) == ".eyeFile") continue;
  $compte++;
  if(is_dir($dir.$f)) {
  echo "<img border='0' src='".findGraphic ('', 'mobile/folder.gif')."'>
  <strong><a href='m.php?path=$udir$f/'>$f</a></strong><br />";
  continue;
  }

  $size = round(filesize($dir . $f) / 1024);
  if (is_file($dir.$f.".eyeFile")) {
    $op = parse_info($dir.$f.".eyeFile");
    $mod = date("d-m-Y H:i", $op["date"] + TOFFSET);
    $fenc = $f;
    $f = $op["filename"];
  }
  else {
    $mod = date("d-m-Y H:i", filemtime($dir . $f) + TOFFSET);
    $fenc = rawurlencode($f);
  }

  $ext = strtolower(substr(strrchr($f, "."), 1));
  $icon = "file.gif";
  if (in_array($ext, Array("png","jpg","jpeg","bmp","gif","tiff","svg"))) $icon = "image.gif";
  if (in_array($ext, Array("html","htm","txt"))) $icon = "text.gif";

  echo "
  <img border='0' src='".findGraphic ('', 'mobile/'.$icon)."' /> <a alt='$size KB. - $mod' title='$size KB. - $mod' href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>$f</a><br />";
 }

closedir($open);
}
if ($compte == 0)
echo _L('This directory is empty')."<br />";

echo '<br /></div><div style="padding: 4px; background-color: #fff8ce;">
  <strong>Upload a file: </strong><br />
  <form action="m.php" enctype="multipart/form-data" method="post">
    <input name="file" type="file">
    <input name="Submit" type="Submit" value="Upload">
    <input type="hidden" name="path" value="'.$udir.'" />
  </form><br />
  <strong>Create a directory: </strong><br />
  <form action="m.php" method="post">
    <input type="hidden" name="path" value="'.$udir.'" />
    <input type="text" name="dirname" maxlength="15" />
    <input name="Submit" type="Submit" value="Create">  
  </form>';
echo '</div>
<small><a href="m.php?exit">Sign out</a> - <a href="desktop.php?a=eyeHome.eyeapp">Desktop version</a></small>
</body>
</html>';
?>
