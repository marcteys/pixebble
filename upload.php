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

require_once  "lib/php/bulletproof/bulletproof.php";

$image = new Bulletproof\Image($_FILES);
$image->setName("caca");

$ds          = DIRECTORY_SEPARATOR;  //1
 
$storeFolder = 'uploads';   //2
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];          //3             
      
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;  //4
     
    $targetFile =  $targetPath. $_FILES['file']['name'];  //5
 
    move_uploaded_file($tempFile,$targetFile); //6
     
}

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