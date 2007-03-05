new<?php
if (defined ('USR') && ! function_exists ('eyeHome')) {
/*
eyeHome.eyeapp
-------------
Version: 1.1

Developers:
-----------
Pau Garcia-Mila
Hans B. Pufal

Possible actions:
----------------
-upload
-remove
-newdir
-removedir

Whole app vars:
--------------
$path: Where you are in your directory tree

TODO:
Order listing of files (first directories, options for ordrering by size, name...)
*/
function eyeHome($eyeapp, &$appinfo) {

$publicdir = ETCDIR."public/";
$publicinfo = ETCDIR."public_xml/";
if (!is_dir($publicdir)) mkdir($publicdir,0777);
if (!is_dir($publicinfo)) mkdir($publicinfo,0777);
if (!is_dir(HOMEDIR)) mkdir(HOMEDIR,0777);
if (!is_dir(HOMEDIR.USR."/")) mkdir(HOMEDIR.USR."/", 0777); 
include $appinfo['appdir']."checkmessages.php"; //eyeMessages check function

if (@$appinfo['argv'][0] == "public")
{
  $public = 1;
  $udir = "";
  $dir = $publicdir;
}
elseif (@$appinfo['argv'][0] == "trash")
{
  $trash = 1;
  $udir = "";
  $dir = USRDIR.USR."/Trash/";
  if (!is_dir($dir)) mkdir($dir, 0777);
} else
{

  if (0 === strpos ($path = realpath (HOMEDIR.USR.'/'.trim(@$_REQUEST['path'])), realpath( HOMEDIR.USR.'/' ))) {
    $size = get_size(HOMEDIR.USR) + get_size(USRDIR.USR);
    $udir = substr ($path, strlen (realpath (HOMEDIR.USR)) + 1);
    if (substr($udir, -1) != "/" && !empty($udir)) $udir .= "/";
    $dir = HOMEDIR.USR."/".$udir;
  } else return 'exit';
}

switch (@strtolower ($_REQUEST['type'])) {

case 'upload':  //Upload a file
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
           createXML ($dir . $name . ".eyeFile", $eyeapp, array (
	          'author' => USR,
	          'filename' => $file,
	          'date' => time())
           );
           msg(_L('File uploaded'));
        }
      }
     }
 }
break;

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
     msg(_L('File moved to trash'));
   }
  }
 }
break;

case 'restore':     //Restore a file
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(basename($_REQUEST['file']));
  $homedirr = HOMEDIR.USR."/";
  if (is_file($dir . $file) && substr($file, -8) != ".eyeFile") {
   if (copy ($dir.$file, $homedirr.$file) && unlink($dir.$file)) {
     if (is_file($dir . $file.".eyeFile"))
     {
       copy ($dir.$file.".eyeFile", $homedirr.$file.".eyeFile");
       unlink($dir.$file.".eyeFile");
     }
     msg(_L('File restored'));
   }
  }
 }
break;

case 'emptytrash':     //Empty the trash
 $dd = dir(USRDIR.USR."/Trash/");
 while($rf = $dd->read()) {
   if ($rf != '.' && $rf != '..') @unlink(USRDIR.USR."/Trash/".basename($rf));
 }
 $dd->close();
 msg(_L('Trash succesfully drained'));
break;

case 'removeperm':     //Delete a file permanently from trash
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(basename($_REQUEST['file']));
  $trashdir = USRDIR.USR."/Trash/";
  if (is_file($trashdir.$file) && substr($file, -8) != ".eyeFile") {
   if (unlink($trashdir.$file)) {
     if (is_file($trashdir . $file.".eyeFile")) unlink($trashdir.$file.".eyeFile");
     msg(_L('File deleted'));
   }
  }
 }
break;

case 'removepublic':     //Delete a file from the public directory
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(basename($_REQUEST['file']));
  if (is_file($publicdir . $file) && substr($file, -8) != ".eyeFile") {
    if (is_file($publicdir . $file.".eyeFile"))
      $filecheck = @parse_info($publicdir . $file.".eyeFile");
    else
      $filecheck = @parse_info($publicinfo . $file.".xml");

    if (USR == $filecheck["author"] || USR == ROOTUSR)
    {
      $trashdir = USRDIR.USR."/Trash/";
      if (!is_dir($trashdir)) mkdir($trashdir, 0777);

      if (is_file($publicdir . $file.".eyeFile")) {
        @copy($publicdir . $file,$trashdir.$file);
        @unlink($publicdir.$file);
        @copy($publicdir . $file.".eyeFile",$trashdir.$file.".eyeFile");
        @unlink($publicdir.$file.".eyeFile");
      } else {
        @copy ($publicdir.$file, $trashdir.$file);
        @unlink($publicdir.$file);
        @unlink($publicinfo.$file.".xml");
      }
      msg(_L('File moved to trash'));
    }
  }
 }
break;

case 'newdir':     //Create a directory
 if (!empty($_REQUEST['dirname'])) {
  $dirname = basename(trim($_REQUEST['dirname']));
  if (eregi ("^[a-z0-9]+$", $dirname))
  {
  if (!empty($dirname) && !file_exists($dir . $dirname)) {
   if (mkdir($dir . $dirname, 0777)) msg(_L('New directory created'));
   }
  } else msg(_L('Please, use only letters and numbers'));
 }
break;

case 'removedir':     //Delete a directory
 if (!empty($_REQUEST['dirname'])) {
  $dirname = basename(trim($_REQUEST['dirname']));
  $dirname = str_replace("./", "", $dirname);
  $dirname = str_replace(".", "", $dirname);
  if (!empty($dirname) && file_exists($dir . $dirname) && is_dir($dir . $dirname)) {
   if (@rmdir($dir . $dirname)) msg(_L('Directory removed')); else  msg(_L('The directory is not empty'));
  }
 }
break;

case 'copytohome':     //Copy a file to Home Dir
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(trim($_REQUEST['file']));
  if (0 === strpos (realpath ($publicdir.$file), realpath( $publicdir )) && is_file($publicdir.$file)) {
   $pieces = explode("/", $file);
   $filename = $pieces[count($pieces)-1];
   if (!is_file(HOMEDIR.USR."/".$filename) && is_file($publicdir.$file) && substr($file, -8) != ".eyeFile")
     {
     copy($publicdir.$file,HOMEDIR.USR."/" . $filename);
     chmod (HOMEDIR.USR."/" . $filename,0777);
     if (is_file($publicdir . $file.".eyeFile")) {
       copy($publicdir . $file.".eyeFile",HOMEDIR.USR."/".$filename.".eyeFile");
       chmod (HOMEDIR.USR."/".$filename.".eyeFile",0777); 
     }
     msg(_L('File copied to Home'));
     }
  }
 }
break;

case 'copytopublic':     //Copy a file to Public Dir
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(trim($_REQUEST['file']));
  if (0 === strpos (realpath (HOMEDIR.USR.'/'.$file), realpath( HOMEDIR.USR.'/' )) && is_file(HOMEDIR.USR."/".$file)) {
   $pieces = explode("/", $file);
   $filename = $pieces[count($pieces)-1];
   if (!is_file($publicdir.$filename) && is_file(HOMEDIR.USR."/".$file) && substr($file, -8) != ".eyeFile")
     {
     copy(HOMEDIR.USR."/".$file,$publicdir . $filename);
     chmod ($publicdir . $filename,0777);
     if (is_file(HOMEDIR.USR."/" . $file.".eyeFile")) {
       copy(HOMEDIR.USR."/" . $file.".eyeFile",$publicdir.$filename.".eyeFile");
       chmod ($publicdir.$filename.".eyeFile",0777); 
     }
     msg(_L('File copied to Public'));
     }
  }
 }
break;

default: break;

}

echo "
<div class='eyeHomemenus'>

    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Sites")."</div>
        <div class='".((!$public && !$trash) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp'><img style='margin-bottom: -3px;' border='0' src='${appinfo['appdir']}img/bar/private.png' /> "._L("My Home")."</a>
        </div>
        <div class='".(($public) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(public)'><img style='margin-bottom: -3px;' border='0' src='${appinfo['appdir']}img/bar/public.png' /> "._L("Public Files")."</a>
        </div>
        <div class='".(($trash) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(trash)'><img style='margin-left: 2px; margin-bottom: -3px;' border='0' src='${appinfo['appdir']}img/bar/trash.png' /> "._L("Trash")."</a>
        </div>

    </div>
    <div class='eyeHomemd'></div>";

if (!isset($public) && !isset($trash))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newdir').style.display='block';\" ><img style='margin-bottom: -3px;' border='0' src='".findGraphic ('', "btn/open.png")."' /> "._L("New Folder")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newupload').style.display='block';\"><img style='margin-bottom: -3px;' border='0' src='${appinfo['appdir']}img/bar/upload.png' /> "._L("Upload a File")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";
elseif (!isset($public))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=$eyeapp(trash)&type=emptytrash'><img style='margin-bottom: -3px;' border='0' src='".findGraphic ('', "btn/delete.png")."' /> "._L("Empty Trash")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";

echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Notifications")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=eyeMessages.eyeapp'><img style='margin-bottom: -3px;' border='0' src='${appinfo['appdir']}img/bar/messages.png' /> ";

if (checkmessages()) echo "<strong>"._L("New Messages")."</strong>";
else echo _L("No new Messages");

echo "</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>

</div>
<div class='eyeHomelist'>";
include $appinfo['appdir']."listfiles.php";
echo "</div>";

echo "<div id='newdir' class='bubble' style='left:50%; margin-left: -30px; top: 150px; width: 190px; height:80px;'>
<div class='bubbletitle' >"._L('Create a new directory')."</div><div align='center'>
  <form action=\"desktop.php?a=$eyeapp\" method=\"post\">
   <input type='hidden' name='type' value='newdir' />
   <input type='hidden' name='path' value='$udir' />
   <div style='margin-bottom: 14px; margin-top: 10px;'><input type='text' name='dirname' maxlength='15' size='22' /></div>
   <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic ('', "btn/upload.png")."' /></div>
  </form>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('newdir').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic ('', "btn/cancelwin.png")."' /></a>
    </div>
</div>
";

if ((USER_QUOTA && $size < USER_QUOTA) || !USER_QUOTA) {
echo "
<div id='newupload' class='bubble' style='left:50%; margin-left: -119px; top: 50%; margin-top: -40px; width: 370px; height:90px; '>
<div class='bubbletitle' >"._L('Upload a file')."</div><div align='center'>
 <div style='margin-top: 15px;'> </div>
 <form action=\"desktop.php?a=$eyeapp\" enctype=\"multipart/form-data\" method=\"post\">
   <input type='hidden' name='type' value='upload' />
   <input name=\"file\" type=\"file\" size=\"30\">
   <div style='margin-top: 10px;'> </div>
   <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic ('', "btn/upload.png")."' />
   <input type='hidden' name='path' value='$udir' />
 </form>
</div>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('newupload').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic ('', "btn/cancelwin.png")."' /></a>
    </div>
</div>
";
}

return '';
}
$appfunction = 'eyeHome';
}
?>
