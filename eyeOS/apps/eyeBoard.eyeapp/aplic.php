<?php

if (defined ('USR') && !function_exists ('eyeBoard')) {

function eyeBoard ($eyeapp, $appinfo) {

  if (!empty ($appinfo['argv'][1]))
    $appinfo['motd'] = $appinfo['argv'][1];
   
  if (empty ($appinfo['motd']) ||((@$appinfo['argv'][0] == 'check') && 
     (filemtime ($appinfo['motd']) < @$appinfo['state.lastread']))) {
    $appinfo['exit'] = 1;
    return 'exit';
  }

  $rows = isset($appinfo['param.rows']) ? $appinfo['param.rows'] : 12; 
  $cols = isset($appinfo['param.cols']) ? $appinfo['param.cols'] : 60; 
  $motd = parse_info ($appinfo['motd']);

  if (USR == ROOTUSR) {
    if (!empty ($_REQUEST['eraseall'])) {
	    @unlink ($appinfo['motd']);
      $motd = array ();
	    msg (_L("All messages have been deleted"));
	  }
  
    if (!empty ($_REQUEST['archive'])) {
	    $arxiu2 = fopen (HOMEDIR.ROOTUSR . "/Archive-eyeBoard.html", 'w');
   	  fwrite ($arxiu2, $motd['motd']);
      fclose ($arxiu2);
	    msg(_L ('Saved'));
	  }

    addActionBar ("<a href='?eraseall=1'><img class='imgbar' border='0' alt='"._L('Erase all messages')."' title='"._L('Erase all messages')."' src='".findGraphic ('', "btn/delete.png")."'></a>");
    addActionBar (" <a href='?archive=1'><img class='imgbar' border='0' alt='"._L('Archive')."' title='"._L('Archive')."' src='".findGraphic ('', "btn/save.png")."'></a>");
  }

  if (!empty ($_REQUEST['motd'])) {
    $motd = array (
     'user' => USR,
     'timestamp' => time()-2,
     'motd' => wordwrap (trim ($_REQUEST['motd']), 45, ' ', 1). "
      &lt;div class='userbox'&gt;
        ".USR." @ ". date('Y-m-d h:i a')."
      &lt;/div&gt;
      &lt;hr class='hrboard'&gt;" . (@$motd ? @$motd['motd'] : ''));
      
    parse_update ($appinfo['motd'], $motd, null, $eyeapp, true);
    msg (_L ('Saved'));
  } 
   
  $_SESSION['apps'][$eyeapp]['state.lastread'] = time () + 1;
  unset ($_SESSION['apps'][$eyeapp]['argv']);
  
  if (@$motd['user'] && @$motd['timestamp'])
    addActionBar (_L("Last changed by %0 %1", $motd['user'], dater ($motd['timestamp'], 1)), 'center');
    $rep1 = Array ("&lt;div class='userbox'&gt;","&lt;/div&gt;","&lt;hr class='hrboard'&gt;");
    $rep2 = Array ("<div class='userbox'>","</div>","<hr class='hrboard'>");
  echo "
    <div style='margin-top:15px;' align='center'>
      <div style='position:relative; width: 90%; height: 75%; border: 1px solid #ccc; overflow:auto; text-align: justify;'>
        ".@str_replace($rep1, $rep2, $motd['motd'])."
      </div><br />
      <form name='canvimsg' action='desktop.php' METHOD='post'>
        <INPUT TYPE='text' size='40' name='motd' /><INPUT TYPE='submit' VALUE='"._L('Update')."' /></form></div>";

  return '';       
}
}

$appfunction = 'eyeBoard';
?>
