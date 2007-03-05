<?php
   $dir = substr($command, strlen("mkdir "));
   if (substr($dir, -1) == "/") $dir = substr($dir, "/", -1);
   $dirname = strtolower(substr(strrchr($dir, "/"), 1));
   $dir = substr($dir, $dirname, -strlen($dirname."/"));
   $displaycmd = $displaycmd."

 >> "._L('Create folder "%0" in "%1"', $dirname, $dir);
   $dir = $dir."/";
   if (substr($dir, 0, 4) == "home") {
      $dir = substr($dir, strlen("home"));
      $dir = HOMEDIR.USR.$dir;
   }
   elseif (substr($dir, 0, 6) == "public") {
      $dir = substr($dir, strlen("public"));
      $dir = ETCDIR."public".$dir;
   }
   elseif (substr($dir, 0, 2) == "os") {
      if (USR == ROOTUSR) $dir = substr($dir, strlen("os/"));
      else {
         $displaycmd = $displaycmd."

 --> "._L("You aren't logged in as root user")." <--";
         $notroot = "yes";
      }
   }
   if (file_exists($dir)) {
   if (!empty($dirname)) {
      if (eregi ("^[a-z+-._0-9]+$", $dirname)) {
         if (!file_exists($dir . $dirname)) {
         if (mkdir($dir . $dirname, 0777)) $displaycmd = $displaycmd."

   >> "._L('New directory created')." <<";
         } else $displaycmd = $displaycmd."

 --> "._L('Folder already exists')." <--";
      } else $displaycmd = $displaycmd."

 --> "._L('Please, use only letters and numbers')." <--";
   } else $displaycmd = $displaycmd."

 --> "._L('Please, specify a name for the new folder')." <--";
   } elseif ($notroot == "yes") $displaycmd = $displaycmd."

 --> "._L('%0 is no real path', $dir)." <--";
?>