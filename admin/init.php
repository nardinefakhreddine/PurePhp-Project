<?php

//connection db
include "connection.php";


 //paths

$tpl="includes/templates/";//templates Directory
$css="layout/css/";//css Directory
$js="layout/js/"; //js Directory
$func="includes/functions/";

//include the important files
include $func."fct.php";

include $tpl."header.php";

//include nav bar on all pages expect the one with $navbar variable
//except admin form login page
if(!isset($navbar)){
include $tpl."navbar.php";

}
?>