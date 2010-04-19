<?php

class TJ_ACCOUNT {
	var $tj_account_id;
	var $tj_tw_token;
	var $tj_tw_id;
	var $tj_avatar;
	var $tj_tw_name;
	var $tj_tw_screenname;
	var $tj_cadmus_api_key;
	
	/*
	* function:		checkAccount()
	* parameters:	EpiTwitter -> twitterInfo
	* description:	Check for existing TJ account
	* return:		true -> if the account already exists
	*				false -> if the account does not exist
	*				call: logEvent() -> if errors during sql or more than 1 entry for the account exists
	*/
	function checkAccount($twitterInfo) {
		if($db = new MySQLDB) {
			$query = "SELECT * FROM tblAccounts WHERE aTwitterID=".$twitterInfo->id;
			$db->begin();
			if($result = mysql_query($query)) {
				if(mysql_num_rows($result) == 1) {
					return true;
				} else if(mysql_num_rows($result) <= 0) {
					return false;
				} else {
					$this->logEvent("checkAccount","$twitterInfo->id","Duplicate entries in tblAccount");
				}
			} else {
				$this->logEvent("checkAccount","admin","Query Error: ".mysql_error());
			}
		}
	}
	
	/*
	* function:		insertAccount()
	* parameters:	EpiTwitter -> twitterInfo
	* description:	add new TJ account into tblAccounts
	* return:		true -> if query was successful
	*				false -> if query was unsuccessful, also calls logEvent();
	*/
	function insertAccount($twitterInfo) {
		if($db = new MySQLDB) {
			$query = "INSERT tblAccounts(aToken,aTwitterID) VALUES('".$_GET['oauth_token']."','{$twitterInfo->id}')";
			$db->begin();
			if(mysql_query($query)) {
				$db->commit();
				return true;
			} else {
				$db->rollback();
				$this->logEvent("insertAccount","$twitterInfo->id","Error:".mysql_error());
				return false;
			}
		}
	}

	/*
	* function:		updateAccount()
	* parameters:	EpiTwitter -> twitterInfo
	* description:	update existing TJ account in tblAccounts
	* return:		true -> if query was successful
	*				false -> if query was unsuccessful, also calls logEvent();
	*/
	function updateAccount($twitterInfo) {
		if($db = new MySQLDB) {
			$query = "UPDATE tblAccounts(aToken,aTwitterID) VALUES('".$_GET['oauth_token']."','{$twitterInfo->id}')";
			$db->begin();
			if(mysql_query($query)) {
				$db->commit();
				return true;
			} else {
				$db->rollback();
				$this->logEvent("updateAccount","$twitterInfo->id","Error:".mysql_error());
				return false;
			}
		}
	}
	
	function logEvent($type, $id, $message) {
	   if($db = new MySQLDB) {
			$db->begin();
			$query = "INSERT INTO tblLog(lType,l_T_id,lMessage) VALUES('$type','$id','$message');";
			if(mysql_query($query)) {
				$db->commit();
				return 1;
			} else {
				$db->rollback();
				//$this->logEvent($type, $id, $message);
				//Email admin
				return 0;
			}
	   }
   }
   
	function init($twitterInfo,$token) {
		//var $tj_account_id;
		//var $tj_cadmus_api_key;
		$this->tj_tw_token = token;
		$this->tj_tw_id = $twitterInfo->id;
		$this->tj_avatar = $twitterInfo->profile_image_url;
		$this->tj_tw_name = $twitterInfo->screen_name;
		$this->tj_tw_screenname = $twitterInfo->screen_name;
   }
}

?>