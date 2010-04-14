<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/index.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/niftyCorners.css">
<link rel="stylesheet" type="text/css" href="css/niftyPrint.css" media="print">
<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/nifty.js"></script>
<script type="text/javascript"> 
$(document).ready(function() {
if(!NiftyCheck())
    return;
	RoundedTop("div#container","#FFF","#8EC1DA");
	RoundedBottom("div#container","#FFF","#8EC1DA");
});
</script>
<title>Tweet Jocky</title>
</head>
<body>
<div id="container">
  <div class="header"><img style="z-index: 1000" src="images/logo.png" alt="Tweet Jocky"/></div>
  <div class="body">
    <div style="padding: 0 20px;">
      <p>Tweet Jocky is a service that will automatically find out what your followers and the friends you follow are talking about, and tweet for you the trending topics that they are interested to see.  It will also give you the option to tweet about hot topics in categories of your choice.</p>
      <br />
      <center>
        <?php
			echo '<a class="hpLink" href="' . $twitterObj->getAuthorizationUrl() . '">Signin with Twitter to get started</a>';
			?>
      </center>
      <br />
      <p>To use this service, you must already have <a class="hpLink" href="http://www.thecadmus.com/" style="font-size: 12pt;">Cadmus</a>.  You can find out more about it or get it free <a class="hpLink" href="http://www.thecadmus.com/"  style="font-size: 12pt;">here</a>.</p>
      <p>Please also read our terms of service and the Twitter rules</p>
    </div>
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