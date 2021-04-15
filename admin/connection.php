<?php
$dsn='mysql::host=localhost;dbname=shop';//data source name
$user='root';//root name
$pass='';//password
/*$option=array(
PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',

);/*/

try{
$con=new PDO($dsn,$user,$pass);//start new connection with PDO
//$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//throw exception





} catch(PDOException $e) {//exception by default
  echo "Connection failed: " . $e->getMessage()." "."<br>";
}
 





 ?>