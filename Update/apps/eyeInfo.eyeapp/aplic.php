<?php
function eyeInfo ($eyeapp, $appinfo) {
   if (!empty ($appinfo['argv']) && (strtolower ($appinfo['argv'][0]) == 'phpinfo') && $Debug) {
      ob_start ();
      phpinfo (-1);
      $phpinfo = ob_get_contents ();
      ob_end_clean ();
      $phpinfo = substr ($phpinfo, strpos ($phpinfo, '<body>')+6);
      echo substr ($phpinfo, 0, strrpos ($phpinfo, '</body>'));
      return;	      
   }
      
   echo "<div align='center' style='margin-top: 20px;'><a href='?a=eyeNav.eyeapp(http://www.eyeos.org)'><img border='0' title='"._L('Under GPL license')."' alt='"._L('Under GPL license')."' src='".findGraphic ('','logo.png')."'></a>
<a href='?a=eyeNav.eyeapp(http://www.eyeos.org/donations)'><img style='margin-bottom: 10px; margin-left: 20px;' border='0' title='"._L('Support eyeOS')."' alt='"._L('Support eyeOS')."' src='".findGraphic ('','support.png')."'></a>
<br />

  <h2>"._L('Core Team')."</h2>
  <table border='0' width='100%' align='center' style='font-size: 80%; text-align: center'>
    <tr><td><strong>Pau Garcia-Milà</strong></td><td>"._L('Barcelona, Spain')."</td><td>"._L('Coder')."</td></tr>
    <tr><td><strong>Marc Cercós</strong></td><td>"._L('Barcelona, Spain')."</td><td>"._L('UI Designer')."</td></tr>
    <tr><td><strong>David Plaza</strong></td><td>"._L('Barcelona, Spain')."</td><td>"._L('Desktop Designer')."</td></tr>
    <tr><td><strong>Hans B. Pufal</strong></td><td>"._L('Greenoble, France')."</td><td>"._L('Coder')."</td></tr>
    <tr><td><strong>Eduardo Pérez Orue</strong></td><td>"._L('Bilbao, Spain')."</td><td>"._L('Business Developer')."</td></tr>
  </table>
<br />
  <h2>"._L('Developers')."</h2>
  <table border='0' width='100%' align='center' style='font-size: 80%; text-align: center'>
    <tr><td><strong>Jose Carlos Norte</strong></td><td>"._L('Barcelona, Spain')."</td><td>"._L('Coder and Security')."</td></tr>
    <tr><td><strong>Daniel Gil</strong></td><td>"._L('Badalona, Spain')."</td><td>"._L('Coder')."</td></tr>
    <tr><td><strong>Lars Knickrehm</strong></td><td>"._L('Hamburg, Germany')."</td><td>"._L('Coder')."</td></tr>
  </table><br /><a href='mailto:team@eyeos.org'>"._L('Contact')."</a><br /><br />
        <hr width='80%' />
<h2>"._L('Related Projects')."</h2>
<h3><a href='?a=eyeNav.eyeapp(http://www.eyeos.nl/miniserver/)'>eyeOS MiniServer</a></h3>
<p>Tristan Siebers (trizz)</p>
<h3><a href='?a=eyeNav.eyeapp(http://eyeos.org/MicroServer)'>eyeOS MicroServer</a></h3>
<p>Björn Ahrens</p>
<h3><a href='?a=eyeNav.eyeapp(http://eyeos.tms-od.de/update-pack-en.html)'>eyeOS Update-Pack</a></h3>
<p>Lars Knickrehm (lars-sh)</p>
<h3>"._L('Documentation Project')."</h3>
<p>"._L('David Bouley (Judland) from Sask., Canada')."</p>
<br />
        <hr width='80%' />
<h2>"._L('System info')."</h2>
";
	
      echo"
        <h3>"._L('User:')." <small>".USR."</small></h3>
        <h3>"._L('Active applications')."</h3>";
 	 
	$tapps = $_SESSION['apps'];
	foreach ($tapps as $app => $appinfo) {
	if (substr($app, -7) == ".eyeapp") { $app = substr($app, 0, -7); }
	if ($app == $appinfo['title'])
	   echo "$app<br/>";
	else 
	   echo "${appinfo['title']} : $app<br />"; }

      echo "<br /><hr width='80%' />
        <h3> "._L('PHP v.')." ". phpversion()."</h3>
	".((false !== strpos (OSVERSION, 'X')) ? "<a href='?a=eyeInfo.eyeapp(phpinfo,-1)'>PHPinfo</a>" :'');
	
      echo "
      <br/><blockquote>
      ".$_SERVER['HTTP_USER_AGENT'].(defined ('BROWSER_IE') ? ' : <strog>MS-IE</strong>' : '')."
      </blockquote></div><br />";
}

$appfunction = 'eyeInfo';
?>
