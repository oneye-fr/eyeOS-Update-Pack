<?php
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
Order listing of files (options for ordrering by size, name...)
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
  $dir = $publicdir;

  if (0 === strpos ($path = realpath ($publicdir.'/'.trim(@$_REQUEST['path'])), realpath( $publicdir.'/' ))) {
    $size = get_size($publicdir) + get_size($publicdir);
    $udir = substr ($path, strlen (realpath ($publicdir)) + 1);
    if (substr($udir, -1) != "/" && !empty($udir)) $udir .= "/";
    $dir = $publicdir."/".$udir;
    $publicinfo = $publicinfo."/".$udir;
  } else return 'exit';
}
elseif (@$appinfo['argv'][0] == "trash")
{
  $trash = 1;
  $udir = "";
  $dir = USRDIR.USR."/Trash/";
  if (!is_dir($dir)) mkdir($dir, 0777);
}
elseif (@$appinfo['argv'][0] == "edit")
{
  $edit = 1;
  $udir = "";
  $dir = USRDIR.USR."/eyeEdit/";
  if (!is_dir($dir)) mkdir($dir, 0777);
}
elseif (@$appinfo['argv'][0] == "pubedit")
{
  $pubedit = 1;
  $udir = "";
  $dir = ETCDIR."/publicnotes/";
  if (!is_dir($dir)) mkdir($dir, 0777);
} else {
  $private = 1;

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
  if ((USER_QUOTA && $size < USER_QUOTA) || !USER_QUOTA || !isset($private)) {
   if (isset($edit) || isset($pubedit)) {
    $fext = "xml";
    $fext2 = ".eyeNote";
   } else {
    $fext = "eyeFile";
    $fext2 = "";
   }
      $name = uniqid(rand()).$fext2;
      $file = basename($_FILES["file"]["name"]);
      while (stristr($file, $fext) !== false) {
          $file = str_ireplace($fext, '', $file);
      }
      $file = basename(strip_tags(trim($file)));
      if (($file != "") && (substr($file, 0, 1) != ".")) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $dir . $name)) {
         if (isset($edit) || isset($pubedit)) {
           createXML ($dir . $name . ".".$fext, $eyeapp, array (
	          'author' => USR,
	          'title' => $file,
	          'date' => time())
           );
           } else {
           createXML ($dir . $name . ".".$fext, $eyeapp, array (
	          'author' => USR,
	          'filename' => $file,
	          'date' => time())
           );
           }
           msg(_L('File uploaded'));
        }
      }
     }
 }
break;

case 'remove':     //Delete a file
 if (!empty($_REQUEST['file'])) {
   if (isset($edit) || isset($pubedit)) {
    $fext = ".xml";
    $name = "title";
   } else {
    $fext = ".eyeFile";
    $name = "filename";
   }
  $file = rawurldecode(basename($_REQUEST['file']));
    if (is_file($dir . $file.".eyeFile"))
      $filecheck = @parse_info($dir . $file.".eyeFile");
    elseif (is_file($dir . $file.".xml"))
      $filecheck = @parse_info($dir . $file.".xml");
    else
      $filecheck = @parse_info($publicinfo . $file.".xml");

      if (isset($private)) $type = "private";
      elseif (isset($public)) $type = "public";
      elseif (isset($edit)) $type = "edit";
      elseif (isset($pubedit)) $type = "pubedit";

    if (USR == $filecheck["author"] || USR == ROOTUSR || !isset($public) && !isset($pubedit))
    {
  $trashdir = USRDIR.USR."/Trash/";
  if (!is_dir($trashdir)) mkdir($trashdir, 0777);
  if (is_file($dir . $file) && substr($file, -8) != ".eyeFile") {
   if (copy ($dir.$file, $trashdir.$file) && unlink($dir.$file)) {
     if (is_file($dir . $file.$fext))
     {
        $op = parse_info($dir . $file.$fext);
           createXML ($trashdir . $file . ".eyeFile", $eyeapp, array (
	          'author' => $op["author"],
	          'filename' => $op[$name],
	          'date' => $op["date"],
              'type' => $type,
              'path' => $_REQUEST['path']));
       unlink($dir.$file.$fext);
   } else {
        $op = parse_info($publicinfo.$file.".xml");
           createXML ($trashdir . $file . ".eyeFile", $eyeapp, array (
	          'author' => $op["author"],
	          'filename' => $op[$name],
	          'date' => $op["date"],
              'type' => $type,
              'path' => $_REQUEST['path']));
        unlink($publicinfo.$file.".xml");
    }
     msg(_L('File moved to trash'));
   }
  }
  }
 }
break;

case 'restore':     //Restore a file
 if (!empty($_REQUEST['file'])) {
  $file = rawurldecode(basename($_REQUEST['file']));
  $op = parse_info($dir.$file.".eyeFile");
  $type = $op["type"];
  $path = $op["path"];
   if ($type == "public") $typedir = ETCDIR."public/";
   elseif ($type == "edit") $typedir = USRDIR.USR."/eyeEdit/";
   elseif ($type == "pubedit") $typedir = ETCDIR."publicnotes/";
   else $typedir = HOMEDIR.USR."/";
   if ($type == "edit" || $type == "pubedit") {
    $fext = ".xml";
    $name = "title";
   } else {
    $fext = ".eyeFile";
    $name = "filename";
   }
  $restoredir = $typedir.$path;
if (!is_dir($restoredir)) $restoredir = $typedir;
  if (is_file($dir . $file) && substr($file, -8) != ".eyeFile") {
   if (copy ($dir.$file, $restoredir.$file) && unlink($dir.$file)) {
     if (is_file($dir . $file.".eyeFile"))
     {
           createXML ($restoredir . $file . $fext, $eyeapp, array (
	          'author' => $op["author"],
	          $name => $op["filename"],
	          'date' => $op["date"]));
       unlink($dir.$file.".eyeFile");
     }
     msg(_L('File restored'));
   }
  }
 }
break;

case 'emptyfolder':     //Empty a folder
 $dd = dir($dir);
 while($file = $dd->read()) {
 if ($file != '.' && $file != '..' && !is_dir($dir.$f)) {
   if (isset($edit) || isset($pubedit)) {
    $fext = ".xml";
    $name = "title";
   } else {
    $fext = ".eyeFile";
    $name = "filename";
   }
    if (is_file($dir . $file.".eyeFile"))
      $filecheck = @parse_info($dir . $file.".eyeFile");
    elseif (is_file($dir . $file.".xml"))
      $filecheck = @parse_info($dir . $file.".xml");
    else
      $filecheck = @parse_info($publicinfo . $file.".xml");

      if (isset($private)) $type = "private";
      elseif (isset($public)) $type = "public";
      elseif (isset($edit)) $type = "edit";
      elseif (isset($pubedit)) $type = "pubedit";

    if (USR == $filecheck["author"] || USR == ROOTUSR || !isset($public) && !isset($pubedit))
    {
  $trashdir = USRDIR.USR."/Trash/";
  if (!is_dir($trashdir)) mkdir($trashdir, 0777);
  if (is_file($dir . $file.$fext) && is_file($dir . $file) && substr($file, -8) != ".eyeFile") {
   if (copy ($dir.$file, $trashdir.$file) && unlink($dir.$file)) {
     if (is_file($dir . $file.$fext))
     {
        $op = parse_info($dir . $file.$fext);
           createXML ($trashdir . $file . ".eyeFile", $eyeapp, array (
	          'author' => $op["author"],
	          'filename' => $op[$name],
	          'date' => $op["date"],
              'type' => $type,
              'path' => $_REQUEST['path']));
       unlink($dir.$file.$fext);
   } else {
        $op = parse_info($publicinfo.$file.".xml");
           createXML ($trashdir . $file . ".eyeFile", $eyeapp, array (
	          'author' => $op["author"],
	          'filename' => $op[$name],
	          'date' => $op["date"],
              'type' => $type,
              'path' => $_REQUEST['path']));
        unlink($publicinfo.$file.".xml");
    }
   }
  }
  }
 }
 }
 $dd->close();
 msg(_L('File(s) moved to trash'));
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

case 'newdir':     //Create a directory
 if (!empty($_REQUEST['dirname'])) {
  $dirname = basename(trim($_REQUEST['dirname']));
  if (eregi ("^[a-z+-._0-9]+$", $dirname))
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

case 'docopy':     //Copy a file
 if (!empty($_REQUEST['file'])) {
  $to = $_REQUEST['copytodir'];
   if (($to == "edit") || ($to == "pubedit")) {
    $toext = ".xml";
    $name1 = "title";
   } else {
    $toext = ".eyeFile";
    $name1 = "filename";
   }
   if ($to == "home") $to = HOMEDIR.USR."/" . $_REQUEST['dirname'] . '/';
   elseif ($to == "public") $to = ETCDIR."public/" . $_REQUEST['dirname'] . '/';
   elseif ($to == "edit") $to = USRDIR.USR."/eyeEdit/" . $_REQUEST['dirname'] . '/';
   elseif ($to == "pubedit") $to = ETCDIR."publicnotes/" . $_REQUEST['dirname'] . '/';
   if (isset($private)) $from = HOMEDIR.USR."/";
   elseif (isset($public)) $from = ETCDIR."public/";
   elseif (isset($edit)) $from = USRDIR.USR."/eyeEdit/";
   elseif (isset($pubedit)) $from = ETCDIR."publicnotes/";
   if (isset($edit) || isset($pubedit)) {
    $fromext = ".xml";
    $name2 = "title";
   } else {
    $fromext = ".eyeFile";
    $name2 = "filename";
   }
   if (file_exists($to)) {
  $file = rawurldecode(trim($_REQUEST['file']));
  if (0 === strpos (realpath ($from.$file), realpath( $from )) && is_file($from.$file)) {
   $pieces = explode("/", $file);
   $filename = $pieces[count($pieces)-1];
   $fileext = strtolower(substr(strrchr($file, "."), 1));
   if ($_REQUEST['copytodir'] == 'home' || $_REQUEST['copytodir'] == 'public') $filename = uniqid(rand());
   else $filename = uniqid(rand()).".eyeNote";
   if (!is_file($to.$filename) && is_file($from.$file) && substr($file, -8) != ".eyeFile" || !is_file($to.$filename) && is_file($from.$file) && substr($file, -4) != ".xml")
     {
     copy($from.$file,$to . $filename);
     chmod ($to . $filename,0777);
     if (is_file($from . $file.$fromext)) {
        $op = parse_info($from . $file.$fromext);
           createXML ($to . $filename . $toext, $eyeapp, array (
	          'author' => $op["author"],
	          $name1 => $op[$name2],
	          'date' => $op["date"]));
       chmod ($to.$filename.$toext,0777); 
     }
     msg(_L('File succesfully copied'));
	 if ($_REQUEST['delorigfile'] == 'on') {
	 unlink($from.$file);
	 if (is_file($from . $file.$fromext)) unlink($from . $file.$fromext);
	 }
     }
	 }
} else msg(_L('The directory doesn\'t exists'));
 }
break;

default: break;

}

echo "
<div class='eyeHomemenus'>

    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Sites")."</div>
        <div class='".(($private) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','private.png')."' /> "._L("My Home")."</a>
        </div>
        <div class='".(($public) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(public)'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','public.png')."' /> "._L("Public Files")."</a>
        </div>
        <div class='".(($trash) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(trash)'><img style='margin-left: 2px; margin-bottom: -3px;' border='0' src='".findGraphic('','trash.png')."' /> "._L("Trash")."</a>
        </div>
        <div class='".(($edit) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(edit)'><img style='margin-left: 2px; margin-bottom: -3px;' border='0' src='".findGraphic('','new.png')."' /> "._L("Private notes")."</a>
        </div>
        <div class='".(($pubedit) ? "eHselected" : "eHmenutxt") ."'>
             <a class='menulink' href='?a=$eyeapp(pubedit)'><img style='margin-left: 2px; margin-bottom: -3px;' border='0' src='".findGraphic('','edit.png')."' /> "._L("Public notes")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";

if (isset($private))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newdir').style.display='block';\" ><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','open.png')."' /> "._L("New Folder")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newupload').style.display='block';\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','restore.png')."' /> "._L("Upload a File")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=$eyeapp&type=emptyfolder&path=$udir' onClick=\"return deletefile()\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','delete.png')."' /> "._L("Empty folder")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";
elseif (isset($public))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newdir').style.display='block';\" ><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','open.png')."' /> "._L("New Folder")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newupload').style.display='block';\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','restore.png')."' /> "._L("Upload a File")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=$eyeapp(public)&type=emptyfolder&path=$udir' onClick=\"return deletefile()\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','delete.png')."' /> "._L("Empty folder")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";
elseif (isset($trash))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' onclick='return deletefile()' href='?a=$eyeapp(trash)&type=emptytrash'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','delete.png')."' /> "._L("Empty Trash")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";
elseif (isset($edit))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=eyeEdit.eyeapp'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','new.png')."' /> "._L("New note")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newupload').style.display='block';\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','restore.png')."' /> "._L("Upload a File")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=$eyeapp(edit)&type=emptyfolder&path=$udir' onClick=\"return deletefile()\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','delete.png')."' /> "._L("Empty folder")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";
elseif (isset($pubedit))
echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Actions")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=eyeEdit.eyeapp'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','new.png')."' /> "._L("New note")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='#' onClick=\"javascript:document.getElementById('newupload').style.display='block';\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','restore.png')."' /> "._L("Upload a File")."</a>
        </div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=$eyeapp(pubedit)&type=emptyfolder&path=$udir' onClick=\"return deletefile()\"><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','delete.png')."' /> "._L("Empty folder")."</a>
        </div>
    </div>
    <div class='eyeHomemd'></div>";

echo "
    <div class='eyeHomemt'></div>
    <div class='eyeHomemc'>
        <div class='eHmenutitle'>"._L("Notifications")."</div>
        <div class='eHmenutxt'>
             <a class='menulink' href='?a=eyeMessages.eyeapp'><img style='margin-bottom: -3px;' border='0' src='".findGraphic('','messages.png')."' /> ";

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

if ($_REQUEST['type'] == 'showcopy') {
echo "<div id='showcopy' class='bubble' style='left:50%; margin-left: -30px; top: 150px; width: 240px; height:90px; display: block;'>
<div class='bubbletitle' >"._L('Copy a file to')."</div><div align='center'>
  <form action=\"desktop.php?a=$eyeapp
     ";
    if (isset($public))
      echo "(public)";
      echo "
 \" method=\"post\">
   <input type='hidden' name='type' value='docopy' />
   <input type='hidden' name='copytodir' value='" . $_REQUEST['copytodir'] . "' />
   <input type='hidden' name='path' value='$udir' />
   <input type='hidden' name='file' value='" . $_REQUEST['file'] . "' />
   <div style='margin-bottom: 14px; margin-top: 10px;'>
     " . $_REQUEST['copytodir'] . " / <input type='text' name='dirname' maxlength='15' size='22' /> /<br /><input name='delorigfile' type='checkbox'>Delete the original file</input></div>
   <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic('','upload.png')."' /></div>
  </form>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('showcopy').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic('','cancelwin.png')."' /></a>
    </div>
</div>
";
}

echo "<div id='newdir' class='bubble' style='left:50%; margin-left: -30px; top: 150px; width: 190px; height:80px;'>
<div class='bubbletitle' >"._L('Create a new directory')."</div><div align='center'>
  <form action=\"desktop.php?a=$eyeapp
     ";
    if (isset($public))
      echo "(public)";
      echo "
 \" method=\"post\">
   <input type='hidden' name='type' value='newdir' />
   <input type='hidden' name='path' value='$udir' />
   <div style='margin-bottom: 14px; margin-top: 10px;'><input type='text' name='dirname' maxlength='15' size='22' /></div>
   <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic('','upload.png')."' /></div>
  </form>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('newdir').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic('','cancelwin.png')."' /></a>
    </div>
</div>
";

if ((USER_QUOTA && $size < USER_QUOTA) || !USER_QUOTA || isset($public)) {
echo "
<div id='newupload' class='bubble' style='left:50%; margin-left: -119px; top: 50%; margin-top: -40px; width: 370px; height:90px; '>
<div class='bubbletitle' >"._L('Upload a File')."</div><div align='center'>
 <div style='margin-top: 15px;'> </div>
 <form action=\"desktop.php?a=$eyeapp
     ";
    if (isset($public))
      echo "(public)";
    elseif (isset($edit))
      echo "(edit)";
    elseif (isset($pubedit))
      echo "(pubedit)";
      echo "
 \" enctype=\"multipart/form-data\" method=\"post\">
   <input type='hidden' name='type' value='upload' />
   <div style='margin-bottom: 14px; margin-top: 10px;'><input name=\"file\" type=\"file\" size=\"30\"></div>
   <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic('','upload.png')."' />
   <input type='hidden' name='path' value='$udir' />
 </form>
</div>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('newupload').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic('','cancelwin.png')."' /></a>
    </div>
</div>
";
}

return '';
}
$appfunction = 'eyeHome';
}
?>
