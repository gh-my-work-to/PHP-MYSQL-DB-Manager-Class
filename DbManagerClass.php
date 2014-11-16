<?php
class MyDbManageClass
{
	
	private $mUrl;
	private $mUser;
	private $mPass;
	
	private $mLink;
	private $mResult;
	
	function __construct()
	{
		$this->mUrl = "localhost";
		$this->mUser = "tester";
		$this->mPass = "tester";
		
		$this->mLink = null;
		$this->mResult = null;
	}
	
	function connect()
	{
		$this->mLink = mysql_connect ( $this->mUrl, $this->mUser, $this->mPass ) or //
		die ( "MySQLへの接続に失敗しました。" );
	}
	
	function retQueryed($sql)
	{
		// データベースを選択する
		// $theDb = mysql_select_db ( $this->mDb, $this->mLink ) or die ( "データベースの選択に失敗しました。" );
		
		// クエリーを実行
		$this->mResult = mysql_query ( $sql, $this->mLink ) or //
die ( "クエリの送信に失敗しました。<br />SQL:" . $sql );
		return $this->mResult;
	}
	
	function release()
	{
		// 結果保持用メモリを開放する
		if ($this->mResult != null)
		{
			mysql_free_result ( $this->mResult );
		}
		
		// MySQLへの接続を閉じるdoit
		if ($this->mLink != null)
		{
			mysql_close ( $this->mLink ) or die ( "MySQL切断に失敗しました。" );
		}
	}
	
	function toString()
	{
		printf ( "%s,%s,%s\n", $this->mUrl, $this->mUser, $this->mPass );
	}
	
	function removeDupli($tableName, $cid, $cname)
	{
		$sql = "DELETE FROM $tableName WHERE $cid NOT IN (
		SELECT min_id FROM (
		SELECT MIN($cid) min_id FROM $tableName GROUP BY $cname
		) tmp
		)";
		
		mysql_query ( $sql, $this->mLink ) or //
die ( "クエリの送信に失敗しました。SQL:" . $sql );
	}

}
?>