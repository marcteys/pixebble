<?php 
if(!empty($_POST['name'])) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$name = $_POST['name'] .'.png';
		$dir = '../../data/uploads/';
		if (exif_imagetype($dir . $name) == IMAGETYPE_PNG) {
				unlink($dir . $name);
		}
	}
}
?>