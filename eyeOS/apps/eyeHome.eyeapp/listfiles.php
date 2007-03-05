<?php

 if ( !defined('USR') ) return;

 //List clickable path in Private Mode
if (!isset($public)) {
  addActionBar("<div class='pathtxt'><a href='?path='>"._L("My Home")."</a>");
  $link = '';
  foreach (explode ('/' , substr($path, strlen(realpath(HOMEDIR.USR.'/')))) as $i)
    if (!empty($i)) addActionBar(" &gt; <a href='?path=".($link .= "$i/")."'>$i</a>");
  addActionBar("</div>");
} else addActionBar("<div class='pathtxt'>"._L("Public Files")."</div>");

if($open=opendir($dir)) {
 echo "
 <script LANGUAGE=\"JavaScript\">
   function estassegurpaperera() {
     var agree = confirm(\""._L('File will be permanently deleted. Continue?')."\");
     return agree; 
   }
   function showOptions(list){
     var eleTog=document.getElementById(list).style;
     if (eleTog.display==\"none\") eleTog.display=\"block\";
     else eleTog.display=\"none\";
   }
 </script>
 <table width='98%' border='0' cellpadding='3'>";

 $compte = 0;
 while ($f = readdir($open) ) {
  if ($f == ".." ||  $f == "." || substr($f, -8) == ".eyeFile") continue;
  $compte++;

  if(is_dir($dir.$f)) {
    echo "
    <tr>
      <td valign='center' width='18'>
        <img border='0' src='${appinfo['appdir']}img/ftypes/folder.png'>
      </td>
      <td valign='center' align='left'>
        <strong><small><a href='?a=$eyeapp&path=$udir$f/'>$f</a></small></strong>
      </td>
      <td align='right' width='30' valign='center'>
        <a onclick='return estassegurpaperera()' href='?a=$eyeapp&type=removedir&dirname=$f&path=$udir'>
          <img style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/delete.png")."'>
        </a>
      </td>
    </tr>
    ";
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
  $icon = "file.png";
  $image_ext = Array("png","jpg","jpeg","bmp","gif","tiff","svg");
  $edit_ext = Array("html","htm","txt");
  if (in_array($ext, $image_ext)) $icon = "image.png";
  if (in_array($ext, $edit_ext)) $icon = "text.png";
  if (strtolower($ext) == "doc") $icon = "doc.png";
  if (strtolower($ext) == "ppt") $icon = "ppt.png";
  if (strtolower($ext) == "xls") $icon = "xls.png";

  echo "
  <tr>
    <td width='18'>
      <img border='0' src='${appinfo['appdir']}img/ftypes/$icon' />
    </td>
    <td align='left'>
  ";
  if ((in_array($ext, $image_ext) || in_array($ext, $edit_ext)) && !isset($public) && !isset($trash))
    echo "
      <small>
        <a alt='$size KB. - $mod' title='$size KB. - $mod' href='?a=eyeViewer.app($udir$fenc)'>$f</a>
      </small>
    ";
  elseif (!isset($public) && !isset($trash))
    echo "
      <small>
        <a alt='$size KB. - $mod' title='$size KB. - $mod' href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>$f</a>
      </small>
    ";
  else 
    echo "
      <small>
        <span alt='$size KB. - $mod' title='$size KB. - $mod'>$f</span>
      </small>
    ";

  echo "
    </td>
    <td align='right'>
      <a href=\"javascript:showOptions('$compte')\">
        <img border='0' src='${appinfo['appdir']}img/box/options.png'/>
      </a>
      <div id='$compte' class='eHbox' style='display:none;' >
  ";
  if (!isset($public) && !isset($trash))
    echo "
      <a href='".SYSDIR."baixar.php?fabaixar=$udir$fenc'>
         <img class='imgbox' alt='"._L('Download')."' title='"._L('Download')."' style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/save.png")."'> "._L('Download')."
      </a>
      <br />
      <a href='?a=$eyeapp&type=copytopublic&file=$udir$fenc'>
         <img class='imgbox' alt='"._L('Copy to Public')."' title='"._L('Copy to Public')."' style='margin-top: 4px;' border='0' src='${appinfo['appdir']}img/box/public.png'> "._L('Copy to Public')."
      </a>
      <br />
      <a onclick='return estassegurpaperera()' href='?a=$eyeapp&type=remove&file=$fenc&path=$udir'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/delete.png")."'> "._L('Delete')."
      </a>
      <br />
    ";
  elseif (!isset($trash)) {
    echo "
      <a href='?a=$eyeapp(public)&type=copytohome&file=$fenc'>
         <img class='imgbox' alt='"._L('Copy to Home')."' title='"._L('Copy to Home')."' style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/save.png")."'> "._L('Copy to Home')."
      </a>
     ";
    if (is_file($publicdir . $fenc.".eyeFile"))
      $filecheck = @parse_info($publicdir . $fenc.".eyeFile");
    else
      $filecheck = @parse_info($publicinfo . $f.".xml");

     if (USR == $filecheck["author"] || USR == ROOTUSR) echo "
      <br />
      <a onclick='return estassegurpaperera()' href='?a=$eyeapp(public)&type=removepublic&file=$fenc'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/delete.png")."'>  "._L('Delete')."
      </a>
       ";
  } else {
    echo "
      <a href='?a=$eyeapp(trash)&type=removeperm&file=$fenc'>
         <img class='imgbox' alt='"._L('Delete')."' title='"._L('Delete')."' style='margin-top: 4px;' border='0' src='".findGraphic ('', "btn/delete.png")."'> "._L('Delete')."
      </a>
      <br />
      <a href='?a=$eyeapp(trash)&type=restore&file=$fenc'>
         <img class='imgbox' alt='"._L('Restore')."' title='"._L('Restore')."' style='margin-top: 4px;' border='0' src='".$appinfo["appdir"]."img/bar/upload.png"."'> "._L('Restore')."
      </a>
     ";
  }
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
if ($compte == 0)
echo "
 <div style='margin-top: 2px; font-size: 12px;'>
   <i>" . _L('This directory is empty') . "</i>
 </div>";
?>
