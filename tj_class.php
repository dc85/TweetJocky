<?php

class tj_account {
	var $tj_account_id;
	var $tj_tw_token;
	var $tj_tw_id;
	var $tj_tw_avatar;
	var $tj_tw_name;
	var $tj_tw_screenname;
	
	function tj_account($twitterInfo,$token) {
		//var $tj_account_id;
		//var $tj_cadmus_api_key;
		$this->tj_tw_token = $token;
		$this->tj_tw_id = $twitterInfo->id;
		$this->tj_tw_avatar = $twitterInfo->profile_image_url;
		$this->tj_tw_name = $twitterInfo->name;
		$this->tj_tw_screenname = $twitterInfo->screen_name;
		
		$cr = $this->checkAccount($twitterInfo);
		
		if($cr < 0) {
			//echo "Something went wrong <br />";
		} elseif($cr == 0) {
			//echo "New account <br />";
			$ir = $this->insertAccount($twitterInfo);
			if($ir == -1) {
				//echo "ERROR: error inserting <br />";
			} else {
				//$this->logEvent("insertAccount","$twitterInfo->id","Error: unable to");
				$this->tj_account_id = $ir;
				//echo "New account inserted <br />";
			}
		} else {
			$ur = $this->updateAccount($twitterInfo);
			$lu = $this->getLastTJ($twitterInfo->id);
			$this->tj_account_id = $ur; 
			//echo "Should update here <br />";
		}
   	}
   
	
	//var $tj_cadmus_api_key;
	
	/*
	* function:		getLastTJ()
	* parameters:	varchar -> twitterInfo->id
	* description:	Check for the last time TJ cycled on the account
	* return:		date -> if the TJ account ran at least once
	*				null -> if the account is new and never ran
	*				call: logEvent() -> if errors during sql or more than 1 entry for the account exists
	*/
	function getLastTJ($id) {
		if($db = new MySQLDB) {
			$query = "SELECT aLastTJ FROM tblAccounts WHERE aTwitterID=".$id.";";
			if($result = mysql_query($query)) {
				if(mysql_num_rows($result) == 1) {
					while($row = mysql_fetch_assoc($result)) {
						return $row['aLastTJ'];
					}
					//return $result;
				} else if(mysql_num_rows($result) <= 0) {
					return 0;
				} else {
					$this->logEvent("checkAccount","$twitterInfo->id","Duplicate entries in tblAccount");
					return -1;
				}
			} else {
				$this->logEvent("checkAccount","admin","Query Error: ".mysql_error());
				return -2;
			}
		}
	}
	
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
			$query = "SELECT * FROM tblAccounts WHERE aTwitterID=".$twitterInfo->id.";";
			if($result = mysql_query($query)) {
				if(mysql_num_rows($result) == 1) {
					while($row = mysql_fetch_assoc($result)) {
						return $row['aID'].",".$row['aTwitterID'];
					}
					//return $result;
				} else if(mysql_num_rows($result) <= 0) {
					return 0;
				} else {
					$this->logEvent("checkAccount","$twitterInfo->id","Duplicate entries in tblAccount");
					return -1;
				}
			} else {
				$this->logEvent("checkAccount","admin","Query Error: ".mysql_error());
				return -2;
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
			$cDate = date("Y-m-d H:i:s",time());
			$query = "INSERT tblAccounts(aToken,aTwitterID,aCreated) VALUES('".$_GET['oauth_token']."','{$twitterInfo->id}','".$cDate."')";
			//echo $query."<br />";
			$db->begin();
			if(mysql_query($query)) {
				$db->commit();
				//return true;
				return mysql_insert_id();
			} else {
				$db->rollback();
				$this->logEvent("insertAccount","$twitterInfo->id","Error:".mysql_error());
				return -1;
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
			$query = "UPDATE tblAccounts SET aToken='".$_GET['oauth_token']."' WHERE aTwitterID=$twitterInfo->id;";
			//echo $query;
			$db->begin();
			if(mysql_query($query)) {
				$db->commit();
				$query = "SELECT aID FROM tblAccounts WHERE aTwitterID=$twitterInfo->id;";
				if($result = mysql_query($query)) {
					$row = mysql_fetch_assoc($result);
					return $row['aID'];
				}
				return true;
			} else {
				$db->rollback();
				$this->logEvent("updateAccount",'".$twitterInfo->id."',"Error:".mysql_error());
				return false;
			}
		}
	}
	
	/*
	* function:		logEvent()
	* parameters:	EpiTwitter -> twitterInfo
	*				vachar -> type: what type of logging message
	*				vachar -> id: for which twitter id
	*				vachar -> message: what is the message
	* description:	update Log errors and other abnormal events in the database
	* return:		1 -> if query was successful
	*				0 -> if query was unsuccessful, also calls logEvent();
	*/
	function logEvent($type, $id, $message) {
	   if($db = new MySQLDB) {
			$db->begin();
			$query = "INSERT INTO tblLog(lType,aTwitterID,lMessage) VALUES('$type','$id','$message');";
			//echo $query."<br />";
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
   
   function init_dump() {
		echo "tj_account_id=>".$this->tj_account_id."<br />";
		//echo "tj_tw_token=>".$this->tj_tw_token."<br />";
		echo "tj_tw_id=>".$this->tj_tw_id."<br />";
		echo "tj_tw_avatar=>".$this->tj_tw_avatar."<br />";
		echo "tj_tw_name=>".$this->tj_tw_name."<br />";
		echo "tj_tw_screenname=>".$this->tj_tw_screenname."<br />";
   }
}

?>