<?php
   $dir = substr($command, strlen("dir "));
   if (substr($dir, -1) == "/") $dir = substr($dir, "/", -1);
   $dir = $dir."/";
   if (substr($dir, 0, 4) == "home") {
      $dir = substr($dir, strlen("home"));
      $dir = HOMEDIR.USR.$dir;
   }
   elseif (substr($dir, 0, 6) == "public") {
      $dir = substr($dir, strlen("public"));
      $dir = ETCDIR."public".$dir;
   }
   elseif (substr($dir, 0, 4) == "edit") {
      $dir = substr($dir, strlen("edit"));
      $dir = USRDIR.USR."eyeEdit/";
      if (!is_dir($dir)) mkdir($dir, 0777);
   }
   elseif (substr($dir, 0, 7) == "pubedit") {
      $dir = substr($dir, strlen("pubedit"));
      $dir = ETCDIR."publicnotes/";
      if (!is_dir($dir)) mkdir($dir, 0777);
   }
   $displaycmd = $displaycmd."
";
   if (file_exists($dir)) {
   $numfiles = 0;
   $numfolders = 0;
   $folders = dir($dir);
   while($f = $folders->read()) {
      if (is_dir($dir.$f)) {
         $numfolders++;
         $displaycmd = $displaycmd."
                      <DIR> $f";
         }
   }
   $folders->close();
   $files = dir($dir);
   while($f = $files->read()) {
      if (!is_dir($dir.$f) && substr($f, -8) != ".eyeFile") {
         $numfiles++;
         if (is_file($dir.$f.".eyeFile")) {
            $op = parse_info($dir.$f.".eyeFile");
            $dati = date(_L('d/m/Y H:i'), $op["date"] + TOFFSET);
            $f = $op["filename"];
         }
      elseif (is_file($dir.$f.".xml")) {
         $op = parse_info($dir.$f.".xml");
         $dati = date(_L('d/m/Y H:i'), $op["date"] + TOFFSET);
         $f = $op["title"];
      }
         else $dati = date(_L('d/m/Y H:i'), filemtime($dir . $f) + TOFFSET);
         $displaycmd = $displaycmd."
    $dati        $f";
      }
   }
   $displaycmd = $displaycmd."
                    $numfiles "._L('file(s)')."
                    $numfolders "._L('folder(s)');
   $files->close();
   } else $displaycmd = $displaycmd."

 --> "._L('Please, specify a real folder')." <--";
?>