<?php
define('UPLOAD_DIR', '../../data/uploads/');

if (!empty($_POST['imgBase64']) && !empty($_POST['userId'])) {

	$id = $_POST['userId'];
	$img = $_POST['imgBase64'];
	$width = $_POST['width'];
	$height = $_POST['height'];

	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace('data:image/jpg;base64,', '', $img);
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace('data:image/gif;base64,', '', $img);
	$img = str_replace(' ', '+', $img);

	$data = base64_decode($img);

	$destination = UPLOAD_DIR . $id. '.png';
	uploadImageAs8BitPNG($data, $destination, $width, $height);

	$timeId = $id.'-' .time();
    $destination = UPLOAD_DIR . $timeId . '.png';
    uploadImageAs8BitPNG($data, $destination, $width, $height);

    $data = array("name"=>$timeId, "user" => $id);
    echo json_encode($data);

}
 ?>