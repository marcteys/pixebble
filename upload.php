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


	define('UPLOAD_DIR', 'images/');
	$img = $_POST['imgBase64'];
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	print $success ? $file : 'Unable to save the file.';


}


/*
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
}
*/
/*
if($image["ikea"]){
    $upload = $image->upload(); 
    $upload = $image->upload(); 

    if($upload){
        // OK
    }else{
        echo $image["error"]; 
    }
}*/


 ?>