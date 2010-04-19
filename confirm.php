<?php
include 'EpiCurl.php';
include 'EpiOAuth.php';
include 'EpiTwitter.php';
include 'secret.php';
include 'tj_class.php';
include 'tj_db.php';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

$twitterObj->setToken($_GET['oauth_token']);
$token = $twitterObj->getAccessToken();
$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;
echo "Your twitter username is {$twitterInfo->screen_name} and your profile picture is <img src=\"{$twitterInfo->profile_image_url}\"> twitter follower {$twitterInfo->id}";

$tj = new TJ_ACCOUNT();

try {
	$tj->init($twitterInfo);
} catch(e) {
	echo "Error initiating TJ account <br />";
	$tj->logEvent("init TJ","$twitterInfo->id","Error initiating the tj account");
}

if($tj->checkAccount($twitterInfo)) {
	$tj->insertAccount($twitterInfo);
} else {
	$tj->updateAccount($twitterInfo);	
}
/*echo "<br />POST<br />";
var_dump($_POST);
echo "<br />GET<br />";
var_dump($_GET);
echo "<br />TwitterInfo<br />";
print_r(twitterInfo);
$tok = file_put_contents('tok', $token->oauth_token);
$sec = file_put_contents('sec', $token->oauth_token_secret);*/

?> 

