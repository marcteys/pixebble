<?php 
if(!empty($_POST['name'])) {
	$name = $_POST['name'] .'.png';
	$dir = '../../public/uploads/';
	if (exif_imagetype($dir . $name) == IMAGETYPE_PNG) {
			unlink($dir . $name);
	}
}
?>