<?php
class DbManagerClass
{
	
	private $mUrl;
	private $mUser;
	private $mPass;
	
	private $mLink;
	private $mResult;
	
	function __construct($url, $user, $pass)
	{
		$this->mUrl = $url;//"localhost";
		$this->mUser = $user;//"tester";
		$this->mPass = $pass;//"tester";
		
		$this->mLink = null;
		$this->mResult = null;
	}
	
	function connect()
	{
		$this->mLink = mysql_connect ( $this->mUrl, $this->mUser, $this->mPass ) or //
		die ( "ERROR! failed to connect to DB." );
	}
	
	function retQueryed($sql)
	{
		// carry on query 
		$this->mResult = mysql_query ( $sql, $this->mLink ) or //
		die ( "ERROR! sending query: SQL:" . $sql );
		return $this->mResult;
	}
	
	function disconnect()
	{
		// free memory
		if ($this->mResult != null)
		{
			mysql_free_result ( $this->mResult );
		}
		
		// disconnect
		if ($this->mLink != null)
		{
			mysql_close ( $this->mLink ) or die ( "ERROR! disconnecting DB." );
			$this->mLink = null;
		}
	}
	
	function removeDupli($tableName, $cid, $cname)
	{
		// remove duplicated records
		$sql = "DELETE FROM $tableName WHERE $cid NOT IN (
		SELECT min_id FROM (
		SELECT MIN($cid) min_id FROM $tableName GROUP BY $cname
		) tmp
		)";
		
		mysql_query ( $sql, $this->mLink ) or //
		die ( "ERROR! sending query on removing duplicated records: SQL:" . $sql );
	}

}
?>