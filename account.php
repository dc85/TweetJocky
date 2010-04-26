<?php
include 'mysqldb.php';

include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
include 'tj_class.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

$twitterObj->setToken($_GET['oauth_token']);
$token = $twitterObj->getAccessToken();
$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;

try {
	echo "Initiating TJ account <br />";
	$_TweetJocky = new tj_account($twitterInfo,$token);
	$_TweetJocky->init_dump();
} catch(Exception $e) {
	echo "Error initiating TJ account <br />";
	$_TweetJocky->logEvent("init TJ","$twitterInfo->id","Error initiating TJ account $e");
}
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
<script type="text/javascript" src="js/account.js"></script>
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
  <div class="menu">
	  <ul class="TJmenu">
		<li id="TJhome"><a href="#home">Home</a></li>
		<li id="TJsettings"><a href="#settings">Settings</a></li>
		<li id="TJfaq"><a href="#faq">FAQ</a></li>
      </ul>
  </div>
  
  <div class="body" style="">
      <div class="account_info">
        <table>
            <tr>
                <td><table><tr><td><img src="<?php echo $_TweetJocky->tj_tw_avatar;?>" style="border: 2px solid white;" /></td></tr></table></td>
                <td>
                    <table>
                        <tr><td><label><?php echo $_TweetJocky->tj_tw_name;?></label></td></tr>
                        <tr><td><label>Last TJ'd:<?php echo (($_TweetJocky->tj_aLastTJ <= 0) ? "never" : $_TweetJocky->tj_aLastTJ);?></label></td></tr>
                    </table>
                </td>
            </tr>
        </table>
        </div>
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