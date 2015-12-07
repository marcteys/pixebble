<?php 
// https://github.com/samayo/bulletproof 

/*
// call if you want to set new image name manually
$image->setName($name); 

// define min/max size limits for upload (size in bytes) 
$image->setSize($min, $max); 

// define acceptable mime types
$image->setMime(array($jpeg, $gif));  

// set max width/height limits (in pixels)
$image->setDimension($width, $height); 

// pass name (and optional chmod) to create folder for storage
$image->setLocation($folderName, $optionalPermission); 
*/
/*
require_once  "lib/php/bulletproof/bulletproof.php";

$image = new Bulletproof\Image($_FILES);
$image->setName("caca");
*/
$ds = "/";
$storeFolder = "uploads";


if (!empty($_POST['imgBase64'])) {
	define('UPLOAD_DIR', '../../public/uploads/');
	$img = $_POST['imgBase64'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace('data:image/jpg;base64,', '', $img);
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace('data:image/gif;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$id = uniqid();
	$id = "last";
	$file = UPLOAD_DIR . $id. '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';
	convertPNGto8bitPNG($file,$file);
}


 function convertPNGto8bitPNG($sourcePath, $destPath) {
    $srcimage = imagecreatefrompng($sourcePath);
    list($width, $height) = getimagesize($sourcePath);
    $img = imagecreatetruecolor($width, $height);
    $bga = imagecolorallocatealpha($img, 0, 0, 0, 127);
    imagecolortransparent($img, $bga);
    imagefill($img, 0, 0, $bga);
    imagecopy($img, $srcimage, 0, 0, 0, 0, $width, $height);
    imagetruecolortopalette($img, false, 255);
    imagesavealpha($img, true);
    imagepng($img, $destPath);
    imagedestroy($img);
  }
 ?>