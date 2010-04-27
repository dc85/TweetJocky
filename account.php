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
	changePane(onTop);
});
</script>
<title>Tweet Jocky</title>
</head>
<body>
<div id="container">
  <div class="header"><img style="z-index: 1000" src="images/logo.png" alt="Tweet Jocky"/></div>
  <div class="menu">
	  <ul class="TJmenu">
		<li id="TJhome"><a href="#" onclick="changePane('TJhome')">Home</a></li>
		<li id="TJsettings"><a href="#" onclick="changePane('TJsettings')">Settings</a></li>
		<li id="TJfaq"><a href="#" onclick="changePane('TJfaq')">FAQ</a></li>
      </ul>
  </div>
  
  <div class="body">
      <div class="account_info" style="border: 1px solid #999999;">
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
    	<div class="tab" id="paneHome"> This is home </div>
        <div class="tab" id="paneSettings">
        	<label class="settings"><sub>BASIC</sub></label>
            <a href="#" class="set">Save</a>
            <hr />
            <center><table>
            	<tr>
                	<td><label class="setting">Cadmus API key: </label></td>
                	<td><input type="text" size="40" />&nbsp;<img src="images/qmark.png" height="14px" width="14px" alt="What's this?" /></td>
                </tr>
            	<tr>
                	<td><label class="setting">Cycle: </label></td>
                    <td>
                    	<select>
                        	<option value="900" disabled="disabled">15 minutes</option>
                        	<option value="1800" disabled="disabled">30 minutes</option>
                        	<option value="3600" disabled="disabled">1 hour</option>
                        	<option value="7200" disabled="disabled">2 hours</option>
                        	<option value="10800" <?php echo ($_TweetJocky->tj_aCycle == "10800") ? "selected='selected'" : "";?>>3 hours</option>
                         	<option value="21600" <?php echo ($_TweetJocky->tj_aCycle == "21600") ? "selected='selected'" : "";?>>6 hours</option>
                        	<option value="43200" <?php echo ($_TweetJocky->tj_aCycle == "43200") ? "selected='selected'" : "";?>>12 hours</option>
                        	<option value="86400" <?php echo ($_TweetJocky->tj_aCycle == "86400") ? "selected='selected'" : "";?>>24 hours</option>
                        </select>&nbsp;<img src="images/qmark.png" height="14px" width="14px" alt="What's this?" />
                    </td>
				</tr>
                <tr>
                	<td><label class="setting">Just the defaults: </label></td>
					<td>
                    	<input type="checkbox" id="set_default" <?php echo ($_TweetJocky->set_sDefault == "1") ? "checked" : "";?> />
	                    &nbsp;<img src="images/qmark.png" height="14px" width="14px" alt="What's this?" />
                    </td>
                </tr>
            </table></center>
            
            <label class="settings"><sub>ADVANCED</sub></label>
            <a href="#" class="set">Save</a>
            <hr />
            <center><table width="100%">
            <thead>
            	<tr><td><label class="settings"><sup>TJ by topic</sup></label></td></tr>
            </thead>
            <tbody>
            	<tr>
                	<td><label class="setting">Entertainment: </label></td>
                    <td><input type="checkbox" id="set_entertainment" <?php echo ($_TweetJocky->set_tEnt == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">News: </label></td>
                    <td><input type="checkbox" id="set_news" <?php echo ($_TweetJocky->set_tNews == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">Business: </label></td>
                    <td><input type="checkbox" id="set_news" <?php echo ($_TweetJocky->set_tBus == "1") ? "checked" : "";?> /></td>
				</tr>
                <tr>
                	<td><label class="setting">Music: </label></td>
                    <td><input type="checkbox" id="set_music" <?php echo ($_TweetJocky->set_tMusic == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">Technology: </label></td>
                    <td><input type="checkbox" id="set_technology" <?php echo ($_TweetJocky->set_tTech == "1") ? "checked" : "";?> /></td>
                    <td><label class="setting">Health: </label></td>
                    <td><input type="checkbox" id="set_technology" <?php echo ($_TweetJocky->set_tHealth == "1") ? "checked" : "";?> /></td>
                </tr>
            </tbody>
            </table></center>

            <center><table width="100%">
            <thead>
            	<tr><td><label class="settings"><sup>TJ by region</sup></label></td></tr>
            </thead>
            <tbody>
            	<tr>
                	<td><label class="setting">Western USA: </label></td>
                    <td><input type="checkbox" id="set_entertainment" <?php echo ($_TweetJocky->set_rUSAw == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">Central USA: </label></td>
                    <td><input type="checkbox" id="set_news" <?php echo ($_TweetJocky->set_rUSAc == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">Eastern USA: </label></td>
                    <td><input type="checkbox" id="set_news" <?php echo ($_TweetJocky->set_rUSAe == "1") ? "checked" : "";?> /></td>
				</tr>
                <tr>
                	<td><label class="setting">Western Canada: </label></td>
                    <td><input type="checkbox" id="set_music" <?php echo ($_TweetJocky->set_rCANw == "1") ? "checked" : "";?> /></td>
                	<td><label class="setting">Central Canada: </label></td>
                    <td><input type="checkbox" id="set_technology" <?php echo ($_TweetJocky->set_rCANc == "1") ? "checked" : "";?> /></td>
                    <td><label class="setting">Eastern Canada: </label></td>
                    <td><input type="checkbox" id="set_technology" <?php echo ($_TweetJocky->set_rCANe == "1") ? "checked" : "";?> /></td>
                </tr>
            </tbody>
            </table></center>

        </div>
	    <div class="tab" id="paneFaq"> this is faq </div>
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