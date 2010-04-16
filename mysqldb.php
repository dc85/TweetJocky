<?php
class MySQLDB 
{
   private $connection;

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect("localhost", "TJ", "unn7td90") or die(mysql_error());
      mysql_select_db("TweetJocky", $this->connection) or die(mysql_error());
   }

   /* Transactions functions */

   function begin(){
      $null = mysql_query("START TRANSACTION", $this->connection);
      return mysql_query("BEGIN", $this->connection);
   }

   function commit(){
      return mysql_query("COMMIT", $this->connection);
   }
   
   function rollback(){
      return mysql_query("ROLLBACK", $this->connection);
   }

   function transaction($q_array){
         $retval = 1;

      $this->begin();

         foreach($q_array as $qa){
            $result = mysql_query($qa['query'], $this->connection);
            if(mysql_affected_rows() == 0){ $retval = 0; }
         }

      if($retval == 0){
         $this->rollback();
         return false;
      }else{
         $this->commit();
         return true;
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
				logEvent($type, $id, $message);
				return 0;
			}
	   }
   }

};
?>