<?php 
//http://markroland.com/blog/restful-php-api/
/**
 * Deliver HTTP Response
 * @param string $format The desired HTTP response content type: [json, html, xml]
 * @param string $api_response The desired HTTP response data
 * @return void
 **/
function deliver_response($api_response){
	$http_response_code = array(
		200 => 'OK',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		403 => 'Forbidden',
		404 => 'Not Found'
	);

	header('HTTP/1.1 '.$api_response['status'].' '.$http_response_code[ $api_response['status'] ]);
	header('Content-Type: application/json; charset=utf-8');
	$json_response = json_encode($api_response);
	echo $json_response;
	exit;
}


function uploadImageAs8BitPNG($data, $destination, $width, $height) {
 	$srcimage = imagecreatefromstring($data);
    $img = imagecreatetruecolor($width, $height);
    $bga = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagecolortransparent($img, $bga);
    imagefill($img, 0, 0, $bga);
    imagecopy($img, $srcimage, 0, 0, 0, 0, $width, $height);
    imagetruecolortopalette($img, false, 255);
    imagesavealpha($img, true);
    imagepng($img, $destination);
    imagedestroy($img);
}



?>