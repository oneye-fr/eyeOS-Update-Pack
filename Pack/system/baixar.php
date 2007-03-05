<?php
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

   include_once "../sysdefs.php";

   if (!isset($_SESSION['usrinfo'])) {
      session_destroy ();
      exit;
   }

   $usr = $_SESSION['usr'];
   $fabaixar = rawurldecode($_REQUEST['fabaixar']);
  if (!isset($_GET['public'])) {
   if (0 === strpos (realpath ("../".mh($usr)."$usr/$fabaixar"),realpath ("../".mh($usr)."$usr/"))) {

   $file = "../".mh($usr).$usr."/".$fabaixar; 
   $lenght = filesize($file);

   if (is_file($file.".eyeFile")) {
     $op = parse_info($file.".eyeFile");
     $filename = $op["filename"];
   }
   else $filename = basename($file);

   if (isset($_REQUEST["view"])) $file_extension = strtolower(substr(strrchr($filename,"."),1));
   else $file_extension = "";
   switch( $file_extension ) {
      case "gif": $ctype="Content-Type: image/gif"; break;
      case "png": $ctype="Content-Type: image/png"; break;
      case "jpeg":
      case "jpg": $ctype="Content-Type: image/jpg"; break;
      case "htm":
      case "html":
      case "txt":  $ctype="Content-Type: text/plain"; break;
      default:
        if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
          $ctype="Content-Type: application/force-download";
        else
          $ctype="Content-Type: application/octet-stream";
      break;
   }

   header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: public");
   header("Content-Description: File Transfer");
   header($ctype);
   header("Content-Disposition: inline; filename=\"".$filename."\";");
   header("Content-Transfer-Encoding: binary");
   header("Content-Length: ".$lenght);
   @readfile($file);
   exit;
}
  } elseif ($_GET['public'] = 1) {
   if (0 === strpos (realpath ("../etc/public/$fabaixar"),realpath ("../etc/public/"))) {

   $file = "../etc/public/".$fabaixar; 
   $lenght = filesize($file);

   if (is_file($file.".eyeFile")) {
     $op = parse_info($file.".eyeFile");
     $filename = $op["filename"];
   }
   else $filename = basename($file);

   if (isset($_REQUEST["view"])) $file_extension = strtolower(substr(strrchr($filename,"."),1));
   else $file_extension = "";
   switch( $file_extension ) {
      case "gif": $ctype="Content-Type: image/gif"; break;
      case "png": $ctype="Content-Type: image/png"; break;
      case "jpeg":
      case "jpg": $ctype="Content-Type: image/jpg"; break;
      case "htm":
      case "html":
      case "txt":  $ctype="Content-Type: text/plain"; break;
      default:
        if(isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'],'MSIE'))
          $ctype="Content-Type: application/force-download";
        else
          $ctype="Content-Type: application/octet-stream";
      break;
   }

   header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: public");
   header("Content-Description: File Transfer");
   header($ctype);
   header("Content-Disposition: inline; filename=\"".$filename."\";");
   header("Content-Transfer-Encoding: binary");
   header("Content-Length: ".$lenght);
   @readfile($file);
   exit;
}
  }
?>
