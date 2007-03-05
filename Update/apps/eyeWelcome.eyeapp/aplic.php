<?php
if (defined ('USR') && !function_exists('eyeWelcome')) {
function eyeWelcome ($eyeapp, &$appinfo) {

if (empty($appinfo['argv'][0]) || !is_numeric($appinfo['argv'][0])) $sc = 1;
elseif ($appinfo['argv'][0] < 7) $sc = $appinfo['argv'][0];
else $sc = 1;
switch ($sc) {

case 1:
	$title = _L("What is eyeOS and what is a \"Web Operating System\"?");
	$screen = "<div class='sc11'>
"._L("To put it simply, a web operating system is similar to the operating system you are already familar with (like Windows, Mac and Linux), except for the fact that it is not stored on the computer that you are using to access it.")."
<br /><br />
"._L("In other words, eyeOS does not need to be installed on your computer in order to use it.")."
</div>

<div class='sc12'>
"._L("Instead, it lives on a remote system that uses the Internet to communicate with you.  Allowing you to access your personal files, safely and securely, from anywhere in the world.")."
<br /><br />
"._L("All you need is a web browser and a connection to the Internet and you have full access to your programs and files.")."
</div>
";
break;

case 2:
	$title = _L("How does my eyeOS desktop work?");
	$screen = "<div class='sc21'>"._L("Once you log in to your new account, you will be presented with the eyeOS main desktop within your web browser window.  Just like any other web page, you click on icons presented to you to launch applications and to carry out system function.")."
<br /><br />
"._L("Your desktop's main application toolbar is loated along the top margin of your browser window.")."</div>

<div class='sc22'>"._L("You will also see a small group of icons in the bottom-right corner of your window.")."
<br /><br />
"._L("This contains your Recycle folder, system clock, and the Log-out button.")."
<br /><br />
"._L("The rest of the screen is your work area.  This is where applications will appear when you open them from the toolbar.")."</div>
";
break;

case 3:
	$title = _L("How do I use the my eyeOS applications?");
	$screen = "
<div class='sc31'>
"._L("Applications are launched by clicking on their respected icons, located in the main system toolbar, as seen here:")."
</div>

<div class='sc32'>
"._L("Clicking on these icons will launch one of the many different tools provided to you.")."
<br /><br />
"._L("Just like your familiar desktop environment, each application will be presented in it's own window within your web brower.")."
<br /><br />
"._L("Your toolbar is capable of displaying up to ten individual application icons at one time.  But there are many more eyeOS applictions available to you.")."
<br /><br />
"._L("To see the entire selection, click on the Plus Sign icon (a.k.a. the eyeApps icon).  A window will appear that will show you all of the programs in table format.")."
<br /><br />
"._L("The next screen will describe some of the more popular appliction icons on your toolbar.")."
</div>
";
break;

case 4:
	$title = _L("Icons on your main toolbar:");
	$screen = "
<div class='sc41'>

<strong>eyeHome</strong> - "._L("This acts as your home directory.  It contains the files you've created and saved to your eyeOS account, as well as notifies you of new personal messages.")."
<br /><br /><br />

<strong>eyeOptions</strong> - "._L("This is where you can configure your desktop environment, account information (like your password), and your main toolbar settings.")."
<br /><br /><br />

<strong>eyeNav</strong> - "._L("This is your eyeOS Internet web browser.  Save bookmarks to your favorite web sites, as well as view other favorite sites submitted by other eyeOS community users.")."
<br /><br /><br />

<strong>eyeCalendar</strong> - "._L("This is your electronic calendar and appointment book.  Keep track of business meetings, birthdays, and any other important dates and reminders at hand at all times.")."
</div>

";
break;

case 5:
	$title = _L("How do I close a running application?");
	$screen = "
<div class='sc51'>
"._L("At the top of each application window, you will see a group of buttons in the top-right corner.  Just like your regular operating system, these buttons can maximize and close the window for the running application.")."
</div>

<div class='sc52'>
"._L("Some applications also have a Help button, displayed as a question mark ? located in the top-left corner of the window.  Click on this icon to get more details about the application and how to use it.")."
<br /><br />
"._L("Also, similar to your regular operating system, you can move the application window about your eyeOS desktop, as well as resize it.  Clicking and dragging the top margin of the window will move it, while clicking and dragging the bottom-right corner will resize.")."
</div>
";
break;

case 6:
	$title = _L("Thanks for choosing eyeOS and welcome!");
	$screen = "
<div class='sc61'>
"._L("... once again.  We, the developers of eyeOS, hope that you enjoy using our on-line web powered operating system and find many uses for it!")."
</div>

<div class='sc62'>
<i>"._L("Remember that this is a community project.  We value your feedback.  Please be sure to visit our forums and Wiki pages and let us know what you'd like to see in future developments in eyeOS and how we can make it an even better experience.")."
<br /><br />
"._L("Enjoy your stay!")."</i>
</div>
";
break;

}

echo "
<div class='wallp' style='background-image: url(\"".$appinfo['appdir']."img/bg.png\");'> </div>
<div class='screen' style='background-image: url(\"".$appinfo['appdir']."img/".$sc.".png\");'> </div>
$screen
<div class='titlesc'>$title</div>
<div class='movearrows'>";
$antsc = $sc - 1;
$segsc = $sc + 1;
if ($sc == 1) echo "<a href='?a=$eyeapp($segsc)'><img style='margin-left: 18px;' border='0' src='".$appinfo["appdir"]."img/right.png'></a>";
if ($sc > 1) echo "<a href='?a=$eyeapp($antsc)'><img title='"._L('Back')."' border='0' src='".$appinfo["appdir"]."img/left.png'></a>";
if ($sc < 6 && $sc != 1) echo "<a href='?a=$eyeapp($segsc)'><img title='"._L('Next')."' style='margin-left: 5px;' border='0' src='".$appinfo["appdir"]."img/right.png'></a>";
if ($sc == 6) echo "<a onclick = 'closeApp (this)' href='?a=eyeHome.eyeapp'><img title='"._L('Next')."' style='margin-left: 5px;' border='0' src='".$appinfo["appdir"]."img/right.png'></a>";
echo " 

</div>
";
  return '';       
}
}
$appfunction = 'eyeWelcome';
?>
