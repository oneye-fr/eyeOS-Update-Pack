<?php
/*
eyeCommand.eyeapp
-----------------
Version: 0.1

Developers:
-----------
Lars Knickrehm

Whole app vars:
---------------
$displaycmd: Text to display for this command
$command: The newest command

ToDo:
-----
More commands !!! (From the eyeOS-Community (eyeForums))
*/
if (defined ('USR') && !function_exists ('eyeCommand')) {
function eyeCommand ($eyeapp, $appinfo) {

// Start "Including the command"
$command = $_REQUEST['command'];
if (isset($command)) {
   $displaycmd = date(_L('d/m/Y h:i a'))." || ".USR." >".$command;
   $run = strchr($command, " ");
   $run = substr($command, $run, -strlen($run));
   $run = $appinfo['appdir']."commands/".$run.".php";
   if (file_exists($run)) include $run;
   else $displaycmd = $displaycmd."

 --> "._L('ATTENTION: Command not found!')." <--";
$displaycmd = $displaycmd."

--------------------------------------------------

".$_REQUEST['displaycmd'];
} elseif (!isset($_REQUEST['displaycmd'])) $displaycmd = date(_L('d/m/Y h:i a'))." || ".USR." >

  >> "._L('Welcome to eyeCommand')." <<";
// End "Including the command"

// Start "Displaying the Window"
addActionBar ("
   <form action='?a=$eyeapp' METHOD='post'>
      <input type='hidden' name='displaycmd' value='$displaycmd' />
      <input style='font-family: monospace;' name='command' size='50' /> <input style='font-family: monospace;' name='submit' type='submit' value="._L('Go')." />
   </form>
");
echo "
   <textarea readonly='readonly' style='width: 100%; height: 88%; background-color: rgb(0, 0, 0); color: rgb(255, 255, 255);' name='fulltext'>$displaycmd</textarea>
";
// End "Displaying the Window"

}
}
$appfunction = 'eyeCommand';
?>