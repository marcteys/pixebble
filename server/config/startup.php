<?php 

include("defines.php");
include('./controllers/functions.php');
include('./models/Images.php');

$_POST   = array_map("filterData", $_POST);
$_GET    = array_map("filterData", $_GET);
$_COOKIE = array_map("filterData", $_COOKIE);