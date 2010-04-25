<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
include 'tj_class.php';
include 'mysqldb.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/jquery.tabs.css">
<link rel="stylesheet" type="text/css" href="css/jquery.tabs-ie.css">
<link rel="stylesheet" type="text/css" href="css/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="css/niftyPrint.css" media="print">
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/nifty.js"></script>
<script type="text/javascript" src="js/jquery.tabs.js"></script>
<script type="text/javascript" src="js/jquery.history_remote.pack.js"></script>
<script type="text/javascript"> 

$(document).ready(function() {
if(!NiftyCheck())
    return;
	RoundedTop("div#container","#FFF","#8EC1DA");
	RoundedBottom("div#container","#FFF","#8EC1DA");
	$("div.body").tabs();
});
</script>
<title>Tweet Jocky</title>
</head>
<body>
<div id="container">
  <div class="header"><img style="z-index: 1000" src="images/logo.png" alt="Tweet Jocky"/></div>
  <div class="body" style="">
    <ul>
      <li><a href="#home"><span>Home</span></a></li>
      <li><a href="#settings"><span>Settings</span></a></li>
      <li><a href="#faq"><span>FAQ</span></a></li>
    </ul>
    <div class="tab" id="home"> This is home </div>
    <div class="tab" id="settings">
      <input type="checkbox" id="set_default" />
      <label for="set_default"> Just give me the default</label>
    </div>
    <div class="tab" id="faq"> this is faq </div>
  </div>
  <div class="footer">
    <center>
      <table border="0">
        <tr>
          <td><img src="images/feed.png" width="12" height="12" alt="rss feed" /><a class="footer" href="#">Rss Feed</a></td>
          <td><img src="images/facebook.png" width="12" height="12" alt="facebook" /><a class="footer" href="#">Facebook</a></td>
          <td><img src="images/twitter.png" width="12" height="12" alt="twitter" /><a class="footer" href="#">Twitter</a></td>
          <td width="250px"></td>
          <td align="right"><span class="footer">Powered by the</span> <a class="footer" href="#">Cadmus</a></td>
        </tr>
      </table>
    </center>
    <table width="100%">
      <tr>
        <td width="100%" align="right" style="padding-right: 30px;"><span class="footer"> © 2010 </span><a class="footer" href="#">Synergos Web Solutions, INC.</a></td>
      </tr>
    </table>
  </div>
</div>
</body>
</html>