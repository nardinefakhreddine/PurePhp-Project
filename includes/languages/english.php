<?php
function lang($phrase){

 static $array= array (
 	//NAVBAR links
 	"HOME_ADMIN"     =>"Home",
 	"ITEMS"          =>"items",
 	"CATEGORIES"     =>"categories",
 	"MEMBERS"        =>"members",
 	"STATISTICS"     =>"statistics",
 	"LOGS"           =>"logs"
 	);

return $array[$phrase];
}



?>