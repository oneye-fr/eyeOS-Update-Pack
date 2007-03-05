<?php

if (!defined ('USR'))  return;
/*
eyeNav.eyeapp
-------------
Version: 1.0.1

Developers:
-----------
Pau Garcia-Mila
Hans B. Pufal

Possible actions:
----------------
-search
-add/substract points (case "points")
-save a bookmark (case "save")
-remove a bookmark (case "remove")

Whole app vars:
--------------
$d: Per-user bookmarks directory
$dp: Public bookmarks directory
$w: Webpage to open in the browser

$_SESSION vars used:
-------------------
lastpage : Active web page in the browser
voted.$p : Check if $p bookmark has been voted yet

TODO
----
-Change all reading cases of $_SESSION['apps'][$eyeapp] to $appinfo
-Put back the break; into the switch, move outside the default and find a way to the default code (after the switch) not overwrite the $w created by "web" case in the switch.
-End cleaning

Make a "engine-mark" system to allow users to add more search engines (or remove them).
Maybe the best way to do it is with a searchengine folder in USR dir with XML files for each search engine.
*/

function eyeNav ($eyeapp, &$appinfo) {

$d = USRDIR.USR."/bookmarks/";
$dp = ETCDIR."publiclinks/";

switch (strtolower (@$_REQUEST['type']))
{
  case 'web':
    if (!empty ($_REQUEST['search']))
    include "${appinfo['appdir']}searchengines.inc.php";
    else {
      $w = strip_tags(trim($_REQUEST['url']));
      if (substr($w, 0, 4) != "http")
        $w = "http://" . $w;
    }
  break;

case 'points':
      $p = basename(trim($_REQUEST['p']));
      if (!isset($_SESSION['apps'][$eyeapp]["voted.$p"]) && (false !== ($r = parse_info ($dp . $p)))) {
        parse_update ($dp . $p, 'karma', $r['karma'] += ($_REQUEST['t']=="a" ? +1 : -1));
        $_SESSION['apps'][$eyeapp]["voted.$p"] = 1;
      }
//we dont break; here, continues to load the lastpage url

  case 'save':
    if (!empty ($_REQUEST['url']) && !empty ($_REQUEST['name']) && !empty ($_REQUEST['pop']))  {
      if (!is_dir($d)) mkdir($d, 0777);
      if (!is_dir($dp)) mkdir($dp, 0777);
      $url = strip_tags($_REQUEST['url']);
      $name = $_REQUEST['name'];
      $pop = strip_tags($_REQUEST['pop']);
      if ($pop == "public") $ds = $dp; else $ds = $d;
        createXML ($ds . time() . ".xml", "bookmark", array (
          'url' => $url,
          'title' => $name,
          'author' => USR,
          'karma' => "0",
          'date' => time()-2, ));
      }
//we dont break; here, continues to load the lastpage url

  case 'remove':
    if (!empty ($_REQUEST['file']))  {	
      $rem = $_REQUEST['file'];
      $rem = basename(trim($rem));
      if (file_exists($d . $rem)) unlink($d . $rem);
    }

    if (!empty ($_REQUEST['filepub']))  {
      $rem = $_REQUEST['filepub'];
      $rem = basename(trim($rem));
      if (is_file($dp . $rem)) {
        $r = parse_info ($dp . $rem);
        $aut = $r['author'];
        if (USR==ROOTUSR || USR==$aut) unlink($dp . $rem);
      }
    }
//we dont break; here, continues to load the lastpage url

  default:
    if(!empty($appinfo['argv'][0])) //Loading a URL via eyeNav.eyeapp(url)
      $w = strip_tags($appinfo['argv'][0]);
    elseif(isset($_SESSION['apps'][$eyeapp]['lastpage']))
      $w = $_SESSION['apps'][$eyeapp]['lastpage'];
    else
      $w = $appinfo['param.startpage'];
  break;

}

$_SESSION['apps'][$eyeapp]['lastpage'] = $w;


addActionBar ("
    <form action='?a=$eyeapp' METHOD='post'>
      <input type='text' name='url' size='65' maxlength='500' />
      <input name='submit' type='submit' value='"._L("Go")."' />");
addActionBar ("
      <select name='engine'>
        <option value='1'>"._L('Google')."</option>
        <option value='2'>"._L('A9')."</option>
        <option value='3'>"._L('Amazon')."</option>
        <option value='4'>"._L('Ask')."</option>
        <option value='5'>"._L('eBay')."</option>
        <option value='6'>"._L('MSN')."</option>
        <option value='7'>"._L('Yahoo')."</option>
      </select>
      <input type='hidden' name='type' value='web' />
      <input name='search' type='submit' value='"._L("Search")."' />
    </form>", 'right');

echo "
  <div style='position: absolute; width: 80%; height: 87%; left: 0; top: 50px;'> 
    <iframe 
      name='showcontent' 
      id='showcontent' 
      class='eyenavifrm' 
      height='100%' 
      width='100%' 
      src='$w'>
    </iframe>
  </div>

  <div style='position: absolute; width: 19%; height: 87%; right: 0; top: 50px; border: 1px solid #D9D9D9; overflow:auto; background-color:#fff;'>
  <script LANGUAGE='JavaScript'>
    function estassegurbook() {
      var agree=confirm('"._L('File will be permanently deleted. Continue?')."');
      if (agree) return true; else return false ; }
  </script>

<span style='font-size:10pt; color:fa912a; margin-left: 4px;'>"._L('Save this page')."</span>
<hr size='1' width='95%' color='ececec' noshade style='margin-top:-2px;'>
<div align='right' style='margin-right: 10px;'>

  <form action='?a=$eyeapp' METHOD='post'>
    <input type='hidden' name='type' value='save' />
    <input type='text' name='name' size='17' maxlength='100' value='"._L('Title')."' />
    <select name='pop'>
      <option value='private'>"._L('Private')."</option> 
      <option value='public'>"._L('Public')."</option>
    </select>
    <input style='border: 0; background-color: transparent; color: #929292; margin-top: 4px; margin-bottom: -2px;' type='image' src='".findGraphic('','save.png')."'>
    <input type='hidden' name='url' value='$w' />
  </form>
</div>
";
//LIST PRIVATE BOOKMARKS
  $c = 0;
  if ($dr = @opendir($d)) {
	  echo "<span style='font-size:10pt; color:fa912a; margin-left: 4px;'>"._L('Private')."</span>
    <hr size='1' width='95%' color='ececec' noshade style='margin-top:-2px;'>
    <table width='99%' border='0' cellspacing='0' cellpadding='2'>";
    while ($bo = readdir($dr))
	    if (false !== ($r = parse_info ($d . $bo))) {
	      $c++;
        if (strlen ($title = $r['title']) > 10)
	        $title = substr($r['title'], 0, 10) . '...';
	      echo "
        <tr>
          <td width='10'>
            <a onclick='return estassegurbook()' href='desktop.php?a=$eyeapp&type=remove&file=$bo'>
              <img border='0' src='".findGraphic('','delete.png')."' />
            </a>
          </td>
          <td>
            <span style='font-size:8pt; color:#adadad;'>
            <a title='$r{['title']}' alt='${r['title']}' href='desktop.php?a=$eyeapp(${r['url']})'>$title</a>
            </span>
          </td>
        </tr>";
	    }
    closedir($dr);
  }
  
	echo "</table>";
      if ($c == 0)
         echo _L('There are no bookmarks');

//LIST PUBLIC BOOKMARKS
  $bookarray = array();
  if ($dr = @opendir($dp)) {
    while ($bo = readdir($dr))
	    if ((false !== ($r = parse_info ($dp.$bo))) && ((USR == ROOTUSR) || (($karma = (empty ($r['karma']) ? 0 : $r['karma'])) >= -5)))
	      $bookarray[] = array ($bo, $r['title'], $r['url'], $karma, $r['author']);
    closedir($dr);
  }

  if (count ($bookarray)) {
    function cmpKarma($a, $b) {
      return ($a[3] == $b[3]) ? 0 : (($a[3] > $b[3]) ? -1 : 1); 
    }

    usort($bookarray, cmpKarma);

    echo "<br />
  <span style='font-size:10pt; color:#fa912a; margin-left: 4px;'>
    "._L('Public')."
  </span>
  <hr size='1' width='95%' color='ececec' noshade style='margin-top:-2px;'>
  <table width='99%' border='0' cellspacing='0' cellpadding='2'>";
  
    foreach ($bookarray as $bo) {
        if (strlen ($title = $bo[1]) > 9) $title = substr($bo[1], 0, 9) . '...';      
      echo "
    <tr>",
     ((USR == ROOTUSR || USR == $bo[4]) ? "
      <td width='10'>
        <a onclick='return estassegurbook()' href='desktop.php?a=$eyeapp&type=remove&filepub=${bo[0]}'>
          <img border='0' src='".findGraphic('','delete.png')."' />
        </a>
      </td>" : ''),
     "<td>
       <span style='font-size:8pt; color:#adadad;'>
         <a title='${bo[1]}' alt='${bo[1]}' href='desktop.php?a=$eyeapp(${bo[2]})'>$title</a>
       </span>
     </td>";

      if (!isset($_SESSION['apps'][$eyeapp]["voted.${bo[0]}"]))
        echo "
     <td align='right' valign='bottom'>
       <a href='desktop.php?a=$eyeapp&type=points&t=a&p=${bo[0]}'>
         <img border='0' src='".findGraphic('','addpoint.png')."'>
       </a>
       <a href='desktop.php?a=$eyeapp&type=points&t=s&p=${bo[0]}'>
         <img border='0' src='".findGraphic('','subpoint.png')."'>
       </a>
     </td>";

      echo "
     <td align='right' valign='bottom'>
       <span style='font-size: 8pt; color: #bababa;'> ${bo[3]}</span>
     </td>
   </tr>";
    }
    
    echo "</table>";
  }
  
  echo "</div>";

return '';       
}

$appfunction = 'eyeNav';
?>
