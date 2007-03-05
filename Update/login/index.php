<?PHP
if (!defined('SYSINFO')) exit;
include "login/loginlang.php";
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='description' content='eyeOS.info - Your eyeOS virtual desktop today.' />
<link rel='stylesheet' href='login/style.css' type='text/css' />
<script src='system/scripts/gclock.js'></script>
<title><?PHP echo $_SESSION['sysinfo']['hostname']; ?></title>
<link rel='icon' href='<?PHP echo findGraphic ('', "icon.gif"); ?>' type='image/x-icon' />  
<link rel='shortcut icon' href='<?PHP echo findGraphic ('', "icon.gif"); ?>' type='image/x-icon' />
</head>
<body OnLoad='document.loginform.usr.focus();'>
<div align="center">

<div class='bodynav'>
<div class='langs'>
<span class='langl'>
<a href='m.php?ll=<?PHP echo $lang ?>'><?PHP echo $mobile_v ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
<a class='langl' href='?ll=bn'>bangla</a> - 
<a class='langl' href='?ll=pt_BR'>brasileiro/português</a> - 
<a class='langl' href='?ll=bg'>bulgarian</a> - 
<a class='langl' href='?ll=ca'>català</a> - 
<a class='langl' href='?ll=zh'>chinese</a> - 
<a class='langl' href='?ll=de'>deutsch</a> - 
<a class='langl' href='?ll=en'>english</a> - 
<a class='langl' href='?ll=es'>español</a> - 
<a class='langl' href='?ll=fr'>français</a> - 
<a class='langl' href='?ll=el'>greek</a> - 
<a class='langl' href='?ll=it'>italiano</a> - 
<a class='langl' href='?ll=nl'>nederlands</a> - 
<a class='langl' href='?ll=ir'>persian</a> - 
<a class='langl' href='?ll=pt'>português</a> - 
<a class='langl' href='?ll=ru'>russian</a> - 
<a class='langl' href='?ll=sk'>slovenský</a> - 
<a class='langl' href='?ll=fi'>suomalainen</a> - 
<a class='langl' href='?ll=sv'>svensk</a> - 
<a class='langl' href='?ll=th'>thai</a> - 
<a class='langl' href='?ll=tr'>türk</a> - 
<a class='langl' href='?ll=ua'>ukrainian</a>
</span>
</div>
<div class='blockbe'><span class='systitle'><?PHP echo $_SESSION['sysinfo']['hostname']; ?></span>
<br /><?PHP if(file_exists ($uc = dirname (SYSINFO).'/infousers.txt') || file_exists ($uc = 'infousers.txt')) echo "$log_were ".trim(file_get_contents($uc))." $log_uac"; ?>
<div style='position: absolute; left: 100px; top: 65px; text-align:left;'>
  <span class='be'><?PHP echo $log_org ?></span>
  <br /><?PHP echo $log_org2 ?>
</div>
<div style='position: absolute; left: 100px; top: 125px; text-align:left;'>
  <span class='be'><?PHP echo $log_prod ?></span>
  <br /><?PHP echo $log_prod2 ?>
</div>
<div style='position: absolute; left: 100px; top: 185px; text-align:left;'>
  <span class='be'><?PHP echo $log_entr ?></span>
  <br /><?PHP echo $log_entr2 ?>
</div>
<div style='position: absolute; left: 100px; top: 245px; text-align:left;'>
  <span class='be'><?PHP echo $log_conn ?></span>
  <br /><?PHP echo $log_conn2 ?>
</div>
</div>


<div class='blocklogin'><div style='margin-top: 90px;'>
<div gclock='format:%H:%i:%s;' style='position:absolute; top:40px; right:10px;'></div>
<span class='systitle'><?PHP echo $_SESSION['sysinfo']['hostname']; ?></span><br />
<?PHP if (!empty ($_SESSION['sysinfo']['hostname']) && (strtolower ($_SESSION['sysinfo']['hostname']) != 'eyeos')) 
echo "<span class='running'>$version ".OSVERSION."</span>"; ?>
	    <div align='center' style='width: 100%; height: 25px; font-size:10pt;'>
        <?PHP echo $logon_msg ?>
      </div> 
	   <div align='left' style='margin-left: 50px; margin-top:0px;'> 
     
     <form name='loginform' action='index.php' method='post'> 
	      <input type='hidden' name='Toffset' value='' />
			<?PHP echo $log_Username ?><br />
			<input type='text' name='usr' maxlength='80' size='18' /><br />
			<?PHP echo $log_Password ?><br />
			<input type='password' name='pwd' maxlength='80' size='18' /><br />
			<?PHP echo $log_Language ?><br /><select name='newlang'>
          <?PHP 
            if (sizeof($Languages) > 1) 
              foreach ($Languages as $l) {
                echo "<option";
                if ($l == $llang) echo " SELECTED";
                echo ">$l</option>\n";
              }
          ?>
		      </select>
          <input type='submit' name='submit' value='<?PHP echo $log_butsignin ?>' />
	    </form></div>
</div></div>

<div class='blockdown'>
    <?PHP
      if (strtolower(CREATE_ACCOUNTS) == "yes") {
    ?>
<div class='blockaccount'><span class='systitle'><?PHP echo $log_create ?></span> <div align='left' style='margin-left: 50px; margin-top:0px;'>
	      <form name='createnew' action='index.php' method='post'> 
		      <?PHP echo $log_Username ?><br />
		      <input type='text' name='newuser' maxlength='80' size='18' />
		      <br /><?PHP echo $log_Password ?><br />
		      <input type='password' name='newpwd' maxlength='80' size='18' />
		      <br /><?PHP echo $log_Email ?><br />
		      <input type='text' name='newmail' maxlength='80' size='11' />
		      <input type='hidden' name='reqkey' value='<?PHP echo $_SESSION['reqkey'] = time() ?>' />

            <input type='submit' name='submit' value='<?PHP echo $log_butcreate ?>' />

	      </form></div>
</div>
<div class='blocktext' style='width: 465px;'>
      <?PHP } else echo "<div class='blocktext' style='width: 465px;'>"; ?>
<div style='text-align:justify; clear:both;'>
<?PHP echo $log_text1 ?> <strong><?PHP echo $_SESSION['sysinfo']['hostname']; ?></strong>, <?PHP echo $log_text2 ?>
<br /><br />
<?PHP echo $log_text3 ?> <strong><?PHP echo $_SESSION['sysinfo']['hostname']; ?></strong> <?PHP echo $log_text4 ?>
        </div>
</div>
</div>

</body>
</html>
