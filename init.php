<?php
//Error Reporting
//ini_set('display_errors','On');
//error_reporting(E_ALL);




//connection db
include "admin/connection.php";

$sessionUser=' ';
if(isset($_SESSION['user'])){
$sessionUser=$_SESSION['user'];

}
//paths
$tpl="includes/templates/";//templates Directory
$css="layout/css/";//css Directory
$js="layout/js/"; //js Directory
$lang="includes/languages/";//languages Directory
$func="includes/functions/";

//include the important files
include $func."fct.php";
include $lang."english.php";
include $tpl."header.php";

//include nav bar on all pages expect the one with $navbar variable
//except admin form login page



?>