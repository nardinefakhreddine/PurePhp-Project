<?php

//function to get title of page
function getTitle(){
global $title;
$title=isset($title)?$title:'default';	
return $title;

}

/* get  all records from any table function v2.0 with condition and order by*/
function getAllfrom($field,$table,$where=null,$and=null,$orderfield,$ordering="DESC"){
global $con;

$getall=$con->prepare("SELECT $field From $table  $where $and order by $orderfield $ordering");
$getall->execute();
$all=$getall->fetchAll();
return $all;

}





/**check if user is not activated
**functions to check the regstatus of the user
**RegStatus=0 not activate and 1 activate
**/
function checkUserStatus($user){
//return zero if the user is activated
	global $con;
$stmt=$con->prepare("SELECT Username , RegStatus from users where Username=? And RegStatus=0");
$stmt->execute(array($user));
$status=$stmt->rowCount();
return $status;//number of rows
}





//function1
function redirectHome($errormsg,$second=3){

echo"<div class='alert alert-danger'> $errormsg </div>";
echo"<div class='alert alert-info'>you will to be redirect to home after $second seconds</div>";
header("refresh:$second;url=index.php");
}

function redirectHome1($msg,$url=null,$second=3){
if($url===null){

	$url='index.php';
	$link='homepage';
}
	else{

		if(isset($_SERVER['HTTP_REFERER'])&& $_SERVER['HTTP_REFERER']!==''){

		$url=$_SERVER['HTTP_REFERER'];
		$link="previous page";
	}

	else{
		$url='index.php';
		$link='homepage';
	}
}

echo $msg;
echo"<div class='alert alert-info'>you will to be redirect to $link after $second seconds</div>";
header("refresh:$second;url=$url");
}


function redirectHome2($msg,$url,$second=3){
echo $msg;
echo"<div class='alert alert-info'>you will to be redirect to after $second seconds</div>";
header("refresh:$second;url=$url");
}


//function to check item if found in database
//$select
//$from table 
//$value the value of select
function checkitem($select,$from,$value){
global $con;

$stmt=$con->prepare("SELECT $select FROM $from WHERE $select=?");
$count=$stmt->rowCount();
return $count;
}


/*count number of items functions v1.0
**function to count items rows
*/
function countItems($item,$table){

global $con;
$stmt=$con->prepare("SELECT COUNT($item)FROM $table ");
$stmt->execute();
return $stmt->fetchColumn(); 


}
function countitem1($select,$from,$value){
global $con;

$stmt=$con->prepare("SELECT $select FROM $from WHERE $select=?");
$stmt->execute(array($value));
$count=$stmt->rowCount();
return $count;
}
//get last id
function getLatest($table,$order,$limit=5){
	global $con;
	$stmt=$con->prepare("SELECT * FROM $table  ORDER BY $order DESC limit $limit");
$stmt->execute();
$row=$stmt->fetchAll();
return $row;


}


?>







