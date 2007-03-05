<?php
if (defined ('USR') && ! function_exists ('eyeEdit')) {
/*
eyeEdit.eyeapp
-------------
Version: 1.0.0

Developers:
-----------
Pau Garcia-Mila
Hans B. Pufal

Possible actions:
----------------


Whole app vars:
--------------
$d : Directory to save data

TODO:
*/
function eyeEdit ($eyeapp, &$appinfo) {

$d = USRDIR.USR."/eyeEdit/";
$dpub = ETCDIR."publicnotes/";
$dpop = @$_REQUEST['public'] == "public" ? $dpub : $d;
$t = time();

switch (@strtolower ($_REQUEST['type'])) {
case 'save':
 if (isset ($_REQUEST['elm1'])) {
  $title = empty ($_REQUEST['notetitle']) ? "Untitled Document" : $_REQUEST['notetitle'];
  $filename = !empty ($_REQUEST['notefile']) ? basename(strip_tags($_REQUEST['notefile'])) : $t;
  if (!is_dir($dpop)) mkdir ($dpop, 0777);
  createXML ($dpop . $filename . ".eyeNote.xml", $eyeapp, array (
	    'title' => $title,
	    'author' => USR,
	    'date' => $t), 1);
  $file = fopen($dpop . $filename . ".eyeNote",'w');
  fwrite ($file,$_REQUEST['elm1']);
  fclose($file);
  $noteinfo = parse_info ($dpop . $filename . ".eyeNote.xml");
  $rtitle = $noteinfo['title'];
  $rfileopen = fopen($dpop . $filename . ".eyeNote",'r');
  if (filesize($dpop . $filename . ".eyeNote") > 0) $rcontent = fread($rfileopen,filesize($dpop . $filename . ".eyeNote")); else $rcontent = "";

  if (isset($_REQUEST['copyhome'])) {
   $file = fopen(HOMEDIR.USR."/". $title . ".html",'w');
   fwrite($file,$_REQUEST['elm1']);
   fclose($file);
  }

  msg(_L('Note %0 succesfully saved', $title));
 }
break;

case 'delete': 
if (isset ($_REQUEST['remove'])) {

  $remove = basename(strip_tags($_REQUEST['remove'])); 
  $removefile = substr($remove, 0, -4);
  if (is_file($dpop . $remove) && is_file($dpop . $removefile)) {
    $filecheck = parse_info($dpop . $remove);
    if ((USR == $filecheck["author"]) || ($dpop == $dpub && USR == ROOTUSR))
    {
      unlink($dpop . $remove);
      unlink($dpop . $removefile);
      msg(_L('Note succesfully deleted'));
    }
  } 
  else msg(_L('Note not exists'));

}
break;

case 'openfile': 
if (isset ($_REQUEST['file'])) {
  $rfile = basename($_REQUEST['file']);
  $filetext = substr($rfile, 0, -4);
  if (is_file($dpop . $rfile)) {
   $noteinfo = parse_info ($dpop . $rfile);
   $rtitle = $noteinfo['title'];
   $rfileopen = fopen($dpop . $filetext,'r');
   if (filesize($dpop . $filetext) > 0) $rcontent = fread($rfileopen,filesize($dpop . $filetext)); else $rcontent = "";
   fclose($rfileopen);
  } 
}
break;

default: 
break;

}

//Editor
//Start new note form
echo "<form action='desktop.php?a=$eyeapp' method='post'>";

//Open notes bubble
echo "<div id='open' class='bubble' style='left:50%; margin-left: -275px; top: 50%; margin-top:-160px; width: 550px; height:320px;'>
<div style='position:absolute; top: -18px; left:-1px; height:18px; width:13px; background-image:url(".findGraphic ('', "btn/bubbles/out.png").");'></div>
<div class='bubbletitle' >"._L('Open a document')."</div><div style='position:absolute; width: 95%; height: 90%; overflow: auto;'>
";

include $appinfo['appdir']."listnotes.php";
echo "</div>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('open').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic ('', "btn/cancelwin.png")."' /></a>
    </div>
</div>
";

//Save this document bubble
echo "
<div id='savedoc' class='bubble' style='left:50%; margin-left: -135px; top: 50%; margin-top: -70px; width: 270px; height:140px;'>
<div class='bubbletitle' >"._L('Save this document')."</div>
<div class='orangebub'>"._L('Title').": 
<input name='notetitle' type='text' size='30' value='".@$rtitle."' /></div>
 <div style='margin-left: 35px;'><input type='checkbox' name='copyhome' /> "._L('Copy to Home as HTML file')." 
<br />
 "._L('Status')." : 
 <select name='public'>
  <option value='private'>"._L('Private')."</option> 
  <option value='public'>"._L('Public')."</option>
 </select> &nbsp;&nbsp; <input style='border: 0; background-color: transparent; color: #929292;' TYPE='image' SRC='".findGraphic ('', "btn/upload.png")."' />
 </div>
   <div class='bubblecancel' style='margin-top: -3px;'>
     <a href='#' onClick=\"javascript:document.getElementById('savedoc').style.display='none';\"><img border='0' alt='"._L('Cancel')."' title='"._L('Cancel')."' src='".findGraphic ('', "btn/cancelwin.png")."' /></a>
    </div>
</div>
";

if ($appinfo['param.rich_editor']) include $appinfo['appdir']."editorload.php";
addActionBar("<a href='desktop.php?a=$eyeapp'>
  <img class='imgbar' border='0' alt='"._L('New note')."' title='"._L('New note')."' src='".findGraphic('','btn/new.png')."' \>
 </a>");
addActionBar("<a href='#' onClick=\"javascript:document.getElementById('open').style.display='block';\">
  <img class='imgbar' border='0' alt='"._L('Open note')."' title='"._L('Open note')."' src='".findGraphic('','btn/open.png')."'>
 </a>");
addActionBar("<a href='#' onClick=\"javascript:document.getElementById('savedoc').style.display='block';\">
  <img class='imgbar' border='0' alt='"._L('Save this document')."' title='"._L('Save this document')."' src='".findGraphic('','btn/save.png')."'>
 </a>");

//Final part of editor form
echo "<div align='center'><div style='width: 98%; height: 87%; margin-top: 10px; text-align: center;'>
<textarea name='elm1' rows='22' cols='80' class='textsize'>".@$rcontent."</textarea></div></div>
      <input name='type' type='hidden' value='save' />
      <input name='notefile' type='hidden' value='".@substr($rfile, 0, -12)."' />
  </form>
  ";
return '';
}
$appfunction = 'eyeEdit';
}
?>
