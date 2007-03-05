<?php
switch ($_REQUEST['engine']) {
  default:
  case '1':
    $w = _L('http://www.google.com/search?q=%0', $_REQUEST['url']);
  break;

  case '2':
    $w = _L('http://a9.com/%0', $_REQUEST['url']);
  break;

  case '3':
    $w = _L('http://www.amazon.com/gp/search/ref=br_ss_hs/102-6134268-4237749?search-alias=aps&keywords=%0', $_REQUEST['url']);
  break;

  case '4':
    $w = _L('http://www.ask.com/web?q=%0', $_REQUEST['url']);
  break;

  case '5':
    $w = _L('http://search.ebay.com/%0', $_REQUEST['url']);
  break;

  case '6':
    $w = _L('http://search.msn.com/results.aspx?q=%0', $_REQUEST['url']);
  break;

  case '7':
    $w = _L('http://search.yahoo.com/search?p=%0', $_REQUEST['url']);
  break;
}
?>