<?php

include("./config/startup.php");

$api_response_code = array(
	0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'),
	1 => array('HTTP Response' => 200, 'Message' => 'Success'),
	2 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'),
	3 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format')
);

$response['code'] = 0;
$response['status'] = 404;
$response['message'] = "Not found";
$response['data'] = NULL;


$request = null;
$action = null;
$success = false;

if(!empty($_GET['action'])) {
	$action = $_GET['action'];
}

if( strcasecmp($_GET['method'],'images') == 0){

	$images = new Images();
	$response = setResponse($response,$api_response_code,1);

	switch ($_SERVER['REQUEST_METHOD']) {
	        case 'POST':
	        	$response['data'] = $images->postImage($_POST);
	            break;
	        case 'PUT':
	        	if(!empty($action)) {
	        		$response['data'] = $images->setActive($action);
	        		$success = true;
	        	}
	            break;
	         case 'GET':
	       		if($action == "search") {
	       			$response['data'] = $images->getImage($_GET['user']);
	       			$success = true;
	       		}
	       		if($action == null) {
	       			$response['data'] = $images->getImages();
	       			$success = true;
	       		}
	            break;
	        default:
	            break;
	}
	if(!$success) $response = setResponse($response,$api_response_code,3);
}

deliver_response($response);

function setResponse($response,$api_response_code, $number) {
	$response['code'] = $number;
	$response['status'] = $api_response_code[ $response['code'] ]['HTTP Response'];
	$response['message'] = $api_response_code[ $response['code'] ]['Message'];
	return $response;
}
?>
		