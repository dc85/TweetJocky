<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
include 'mysqldb.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

$twitterObj->setToken($_GET['oauth_token']);
$token = $twitterObj->getAccessToken();
$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;
echo "Your twitter username is {$twitterInfo->screen_name} and your profile picture is <img src=\"{$twitterInfo->profile_image_url}\"> twitter follower {$twitterInfo->id}";
insertAccount($twitterInfo);
/*echo "<br />POST<br />";
var_dump($_POST);
echo "<br />GET<br />";
var_dump($_GET);
echo "<br />TwitterInfo<br />";
print_r(twitterInfo);
$tok = file_put_contents('tok', $token->oauth_token);
$sec = file_put_contents('sec', $token->oauth_token_secret);*/

function checkAccount() {
	if($db = new MySQLDB) {
		$query = "SELECT * FROM tblAccounts WHERE aTwitterID=".$twitterInfo->id;
		$db->begin();
		if($result = mysql_query($query)) {
			if(mysql_num_rows($result) == 1) {
				return true;
			} else if(mysql_num_rows($result) <= 0) {
				return false;
			} else {
				$db->logEvent("checkAccount","$twitterInfo->id","Duplicate entries in tblAccount");
			}
		} else {
			$db->logEvent("checkAccount","admin","Query Error: ".mysql_error());
		}
	}
}

function insertAccount($twitterInfo) {
	if($db = new MySQLDB) {
		$query = "INSERT tblAccounts(aToken,aTwitterID) VALUES('".$_GET['oauth_token']."','{$twitterInfo->id}')";
		$db->begin();
		if(mysql_query($query)) {
			$db->commit();
			return true;
		} else {
			$db->rollback();
			return false;
		}
	}
}

function updateAccount($twitterInfo) {
	if($db = new MySQLDB) {
		$query = "UPDATE tblAccounts(aToken,aTwitterID) VALUES('".$_GET['oauth_token']."','{$twitterInfo->id}')";
		$db->begin();
		if(mysql_query($query)) {
			$db->commit();
			return true;
		} else {
			$db->rollback();
			return false;
		}
	}
}
?> 

