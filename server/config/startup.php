<?php 

include("defines.php");
include('./controllers/functions.php');
include('./models/Images.php');

function filterData($data){
	if(is_array($data))
		$data = array_map("filterData", $data);
	else		
		$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
	
	return $data;
}
$_POST   = array_map("filterData", $_POST);
$_GET    = array_map("filterData", $_GET);
$_COOKIE = array_map("filterData", $_COOKIE);
