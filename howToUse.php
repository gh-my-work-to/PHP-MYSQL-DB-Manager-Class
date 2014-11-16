<?php 
require 'DbManagerClass.php';

$url = "localhost";
$user = "tester";
$pass = "tester";

$obj = new DbManagerClass($url, $user, $pass);
$obj->connect();

$res = $obj->retQueryed("select * from dbTest.tTest");
print mysql_num_rows($res).PHP_EOL;

$obj->disconnect();
?>