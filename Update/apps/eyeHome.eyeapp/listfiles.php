<?php

 if ( !defined('USR') ) return;

 //List clickable path in Private Mode
if (isset($private)) {
  addActionBar("<div class='pathtxt'><a href='?a=eyeHome.eyeapp'>"._L("My Home")."</a>");
  foreach (explode ('/' , substr($path, strlen(realpath(HOMEDIR.USR.'/')))) as $i)
   if (!empty($i)) addActionBar(" &gt; <a href='?path=$i/'>$i</a>");
  addActionBar("</div>");
} elseif (isset($public)) {
  addActionBar("<div class='pathtxt'><a href='?a=eyeHome.eyeapp(public)'>"._L("Public Files")."</a>");
  foreach (explode ('/' , substr($path, strlen(realpath($publicdir)))) as $i)
   if (!empty($i)) addActionBar(" &gt; <a href='?path=$i/'>$i</a>");
  addActionBar("</div>");
} elseif (isset($trash)) {
  addActionBar("<div class='pathtxt'><a href='?a=eyeHome.eyeapp(trash)'>"._L("Trash")."</a></div>");
} elseif (isset($edit)) {
  addActionBar("<div class='pathtxt'><a href='?a=eyeHome.eyeapp(edit)'>"._L("Private notes")."</a></div>");
} elseif (isset($pubedit)) {
  addActionBar("<div class='pathtxt'><a href='?a=eyeHome.eyeapp(pubedit)'>"._L("Public notes")."</a></div>");
}

 echo "
 <script LANGUAGE=\"JavaScript\">
   function deletefile() {
     var agree = confirm(\""._L('File(s) will be permanently deleted. Continue?')."\");
     return agree; 
   }
   function deletedir() {
     var agree = confirm(\""._L('Folder will be permanently deleted. Continue?')."\");
     return agree; 
   }
   function showOptions(list){
     var eleTog=document.getElementById(list).style;
     if (eleTog.display==\"none\") eleTog.display=\"block\";
     else eleTog.display=\"none\";
   }
 </script>";
 
 if (isset($private) || isset($public)) echo"
 <table width='98%' border='0' cellpadding='3'>
 <tr>
      <td colspan='3' valign='center' align='center'>
        <strong><small>"._L('Directories')."</small></strong>
      </td>";

if($open=opendir($dir)) {

 $compte = 0;
 while ($f = readdir($open) ) {
  if ($f == ".." ||  $f == "." || !is_dir($dir.$f)) continue;
  $compte++;

if (isset($private)) {
    echo "
    <tr>
      <td valign='center' width='18'>
        <img border='0' src='".findGraphic('','folder.png')."'>
      </td>
      <td valign='center' align='left'>
        <strong><small><a href='?a=$eyeapp&path=$udir$f/'>$f</a></small></strong>
      </td>
      <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=$eyeapp&path=$udir$f/'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='".findGraphic('','folder.png')."'> "._L('Open')."</strong>
      </a>
      <br />
      <hr>
      <a onclick='return deletedir()' href='?a=$eyeapp&type=removedir&dirname=$f&path=$udir'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      <br />
      <a onclick='return deletefile()' href='?a=$eyeapp&type=emptyfolder&path=$udir$f'>
         <img class='imgbox' alt='"._L('Empty folder')."' title='"._L('Empty folder')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Empty folder')."
      </a>
      </div>
     </td>
    </tr>
    ";
} elseif (isset($public)) {
    echo "
    <tr>
      <td valign='center' width='18'>
        <img border='0' src='".findGraphic('','folder.png')."'>
      </td>
      <td valign='center' align='left'>
        <strong><small><a href='?a=$eyeapp(public)&path=$udir$f/'>$f</a></small></strong>
      </td>
      <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=$eyeapp(public)&path=$udir$f/'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='".findGraphic('','folder.png')."'> "._L('Open')."</strong>
      </a>
      <br />
      <hr>
      <a onclick='return deletedir()' href='?a=$eyeapp(public)&type=removedir&dirname=$f&path=$udir'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      </div>
     </td>
    </tr>
    ";
}
  echo "
      </div>
    </td>
  </tr>
  ";
 }
 if (isset($private) || isset($public)) echo "
 </table>
 ";
 closedir($open);
if (isset($private) || isset($public)) {
if ($compte == 0) echo "<div style='margin-top: 2px; font-size: 12px;'>
   <i>" . _L('No folder available') . "</i>
 </div>";
else echo "<div style='margin-top: 2px; font-size: 12px;' align='right'>
   <i>" . _L('%0 folder(s)', $compte) . "&nbsp;&nbsp;</i>
 </div>";
 }
 }
if($open=opendir($dir)) {
 echo "
  <table width='98%' border='0' cellpadding='3'>";
if (isset($private) || isset($public)) echo"
 <tr>
      <td colspan='3' valign='center' align='center'>
        <strong><small>"._L('Files')."</small></strong>
      </td>";
 $compte2 = 0;
  while ($f = readdir($open) ) {
  if ($f == ".." ||  $f == "." || substr($f, -8) == ".eyeFile" || substr($f, -12) == ".eyeNote.xml" || is_dir($dir.$f)) continue;
  $compte++;
  $compte2++;

  $size = round(filesize($dir . $f) / 1024);
  if (is_file($dir.$f.".eyeFile")) {
    $op = parse_info($dir.$f.".eyeFile");
    $mod = date(_L('d/m/Y h:i a'), $op["date"] + TOFFSET);
    $fenc = $f;
    $f = $op["filename"];
  }
  elseif (is_file($dir.$f.".xml")) {
    $op = parse_info($dir.$f.".xml");
    $mod = date(_L('d/m/Y h:i a'), $op["date"] + TOFFSET);
    $fenc = $f;
    $f = $op["title"];
  }
  else {
    $mod = date(_L('d/m/Y h:i a'), filemtime($dir . $f) + TOFFSET);
    $fenc = rawurlencode($f);
  }

  $ext = strtolower(substr(strrchr($f, "."), 1));
  $icon = findGraphic('','new.png');
  $image_ext = Array("png","jpg","jpeg","bmp","gif","tiff","svg");
  $edit_ext = Array("html","htm","txt");
  $doc_ext = Array("odt","sxw","doc","sdw");
  $xls_ext = Array("ods","sxc","xls","sdc");
  $ppt_ext = Array("odp","sxi","ppt","sdd");
  if (in_array($ext, $image_ext)) $icon = findGraphic('','image.png');
  if (in_array($ext, $edit_ext)) $icon = findGraphic('','edit.png');
  if (in_array($ext, $doc_ext)) $icon = findGraphic('','doc.png');
  if (in_array($ext, $xls_ext)) $icon = findGraphic('','xls.png');
  if (in_array($ext, $ppt_ext)) $icon = findGraphic('','ppt.png');

  echo "
  <tr>
    <td width='18'>
      <img border='0' src='$icon' />
    </td>
    <td align='left'>
  ";
  if ((in_array($ext, $image_ext) || in_array($ext, $edit_ext)) && isset($private))
    echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='?a=eyeViewer.app($udir$fenc)'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=eyeViewer.app($udir$fenc)'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='$icon'> "._L('Open')."</a></strong>
      <br />
      <hr>
      <a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>
         <img class='imgbox' alt='"._L('Download')."' title='"._L('Download')."' style='margin-top: 4px;' border='0' src='".findGraphic('','save.png')."'> "._L('Download')."
      </a>
      <br />
    ";
  elseif (isset($private))
    echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>
         <strong><img class='imgbox' alt='"._L('Download')."' title='"._L('Download')."' style='margin-top: 4px;' border='0' src='".findGraphic('','save.png')."'> "._L('Download')."</a></strong>
      <br />
      <hr>
    ";
  if ((in_array($ext, $image_ext) || in_array($ext, $edit_ext)) && isset($public))
    echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='?a=eyePubViewer.app($udir$fenc)'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=eyePubViewer.app($udir$fenc)'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='$icon'> "._L('Open')."</a></strong>
      <br />
      <hr>
      <a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc&public=1'>
         <img class='imgbox' alt='"._L('Download')."' title='"._L('Download')."' style='margin-top: 4px;' border='0' src='".findGraphic('','save.png')."'> "._L('Download')."
      </a>
      <br />
    ";
  elseif (isset($public))
  echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='".SYSDIR."baixar.php?fabaixar=$udir$fenc&public=1'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc&public=1'>
         <strong><img class='imgbox' alt='"._L('Download')."' title='"._L('Download')."' style='margin-top: 4px;' border='0' src='".findGraphic('','save.png')."'> "._L('Download')."
         </a></strong>
      <br />
      <hr>
     ";
  elseif (isset($trash))
    echo "
      <small>
        <span alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod'>$f</span>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a onclick='return deletefile()' href='?a=$eyeapp(trash)&type=removeperm&file=$fenc'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      <br />
      <a href='?a=$eyeapp(trash)&type=restore&file=$fenc'>
         <img class='imgbox' alt='"._L('Restore')."' title='"._L('Restore')."' style='margin-top: 4px;' border='0' src='".findGraphic('','restore.png')."'> "._L('Restore')."
      </a>
    ";
  elseif (isset($edit))
    echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='?a=eyeEdit.eyeapp&type=openfile&file=$fenc.xml'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=eyeEdit.eyeapp&type=openfile&file=$fenc.xml'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='$icon'> "._L('Open')."</a></strong>
      <br />
      <hr>
      <a onclick='return deletefile()' href='?a=$eyeapp(edit)&type=remove&file=$fenc'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      <br />
      <a href='?a=$eyeapp(edit)&type=copy&to=private&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to Home')."' title='"._L('Copy to Home')."' style='margin-top: 4px;' border='0' src='".findGraphic('','private.png')."'> "._L('Copy to Home')."
      </a>
      <br />
      <a href='?a=$eyeapp(edit)&type=copy&to=public&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to Public')."' title='"._L('Copy to Public')."' style='margin-top: 4px;' border='0' src='".findGraphic('','public.png')."'> "._L('Copy to Public')."
      </a>
      <br />
      <a href='?a=$eyeapp(edit)&type=copy&to=pubedit&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to public Notes')."' title='"._L('Copy to public Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','edit.png')."'> "._L('Copy to public Notes')."
      </a>
    ";
  elseif (isset($pubedit)) {
    echo "
      <small>
        <a alt='$size "._L('KB')." - $mod' title='$size "._L('KB')." - $mod' href='?a=eyeEdit.eyeapp&type=openfile&file=$fenc.xml&public=public'>$f</a>
      </small>
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='".findGraphic('','options.png')."'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
      <a href='?a=eyeEdit.eyeapp&type=openfile&file=$fenc.xml&public=public'>
         <strong><img class='imgbox' alt='"._L('Open')."' title='"._L('Open')."' style='margin-top: 4px;' border='0' src='$icon'> "._L('Open')."</a></strong>
      <br />
      <hr>
     ";
    if (is_file($dir . $fenc.".xml"))
      $filecheck = @parse_info($dir . $fenc.".xml");
    else
      $filecheck = @parse_info($publicinfo . $f.".xml");

     if (USR == $filecheck["author"] || USR == ROOTUSR) echo "
      <a onclick='return deletefile()' href='?a=$eyeapp(pubedit)&type=remove&file=$fenc'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      <br />
      ";
      echo "
      <a href='?a=$eyeapp(pubedit)&type=copy&to=private&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to Home')."' title='"._L('Copy to Home')."' style='margin-top: 4px;' border='0' src='".findGraphic('','private.png')."'> "._L('Copy to Home')."
      </a>
      <br />
      <a href='?a=$eyeapp(pubedit)&type=copy&to=public&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to Public')."' title='"._L('Copy to Public')."' style='margin-top: 4px;' border='0' src='".findGraphic('','public.png')."'> "._L('Copy to Public')."
      </a>
      <br />
      <a href='?a=$eyeapp(pubedit)&type=copy&to=edit&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to private Notes')."' title='"._L('Copy to private Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','new.png')."'> "._L('Copy to private Notes')."
      </a>
    "; }

  if (isset($private))
    echo "
      <a onclick='return deletefile()' href='?a=$eyeapp&type=remove&file=$fenc&path=$udir'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'> "._L('Delete')."
      </a>
      <br />
      <a href='?a=$eyeapp&type=copy&to=public&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to Public')."' title='"._L('Copy to Public')."' style='margin-top: 4px;' border='0' src='".findGraphic('','public.png')."'> "._L('Copy to Public')."
      </a>
      <br />
      <a href='?a=$eyeapp&type=copy&to=edit&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to private Notes')."' title='"._L('Copy to private Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','new.png')."'> "._L('Copy to private Notes')."
      </a>
      <br />
      <a href='?a=$eyeapp&type=copy&to=pubedit&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to public Notes')."' title='"._L('Copy to public Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','edit.png')."'> "._L('Copy to public Notes')."
      </a>
    ";


  if (isset($public)) {
    if (is_file($dir . $fenc.".eyeFile"))
      $filecheck = @parse_info($dir . $fenc.".eyeFile");
    else
      $filecheck = @parse_info($publicinfo . $f.".xml");

     if (USR == $filecheck["author"] || USR == ROOTUSR) echo "
      <a onclick='return deletefile()' href='?a=$eyeapp(public)&type=remove&file=$fenc&path=$udir'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic('','delete.png')."'>  "._L('Delete')."
      </a>
      <br />
      ";
      echo "
      <a href='?a=$eyeapp(public)&type=copy&to=private&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to Home')."' title='"._L('Copy to Home')."' style='margin-top: 4px;' border='0' src='".findGraphic('','private.png')."'> "._L('Copy to Home')."
      </a>
      <br />
      <a href='?a=$eyeapp(public)&type=copy&to=edit&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to private Notes')."' title='"._L('Copy to private Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','new.png')."'> "._L('Copy to private Notes')."
      </a>
      <br />
      <a href='?a=$eyeapp(public)&type=copy&to=pubedit&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to public Notes')."' title='"._L('Copy to public Notes')."' style='margin-top: 4px;' border='0' src='".findGraphic('','edit.png')."'> "._L('Copy to public Notes')."
      </a>
    "; }


  echo "
      </div>
    </td>
  </tr>
  ";
        
 }

 echo "
 </table>
 ";
 closedir($open);
}


if (isset($private) || isset($public)) {
if ($compte2 == 0) echo "<div style='margin-top: 2px; font-size: 12px;'>
   <i>" . _L('No file available') . "</i>
 </div>";
else echo "<div style='margin-top: 2px; font-size: 12px;' align='right'>
   <i>" . _L('%0 file(s)', $compte2) . "&nbsp;&nbsp;</i>
 </div>";
}

if (!isset($private) && !isset($public)) {
if ($compte == 0) echo "<div style='margin-top: 2px; font-size: 12px;'>
   <i>" . _L('This directory is empty') . "</i>
 </div>";
else echo "<div style='margin-top: 2px; font-size: 12px;' align='right'>
   <i>" . _L('%0 file(s)', $compte) . "&nbsp;&nbsp;</i>
 </div>";
 }
?>
