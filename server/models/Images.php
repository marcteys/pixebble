<?php
class Images{

	/*
    function getImages(){
        return self::makeData();
    }*/

	 function getImages(){
	 		$cdir = scandir(UPLOAD_DIR);
			$files = null;
			foreach ($cdir as $key => $filename) 
			{ 
			  if (!in_array($filename,array(".",".."))) 
			  {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
					$timestamp =  substr($withoutExt, -10);
					$user = trim($withoutExt, "-".$timestamp);
				    $files[] = array("name" => $filename,  "user"=> $user, "timestamp" => $timestamp, "uploadDir" => UPLOAD_DIR_ABS);
			  }
			}
			if($files == null)  $files[] = array("files" => null);
			else sort($files);
			return $files;
	 }

	 function getImage($user) {
	 		$cdir = scandir(UPLOAD_DIR);
			$files = null;
			foreach ($cdir as $key => $filename) 
			{ 
			  if (!in_array($filename,array(".",".."))) 
			  {
					$withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
					$timestamp =  substr($withoutExt, -10);
					$filenameSimple = trim($withoutExt, "-".$timestamp);
					if($filenameSimple == $user)
				    	$files[] = array("name" => $withoutExt, "user" => $user, "timestamp" => $timestamp);
			  }
			}
			if($files == null) $files[] = array("name" => null,  "user"=> $user, "timestamp" => null, "uploadDir" => null);
			return $files;
	 }

	 function postImage($data) {
	 	if (!empty($data['imgBase64']) && !empty($data['userId'])) {
			
			$id = $data['userId'];
			$img = $data['imgBase64'];
			$width = $data['width'];
			$height = $data['height'];

			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace('data:image/jpg;base64,', '', $img);
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace('data:image/gif;base64,', '', $img);
			$img = str_replace(' ', '+', $img);

			$imgData = base64_decode($img);

			$destination = UPLOAD_DIR . $id. '.png';
			uploadImageAs8BitPNG($imgData, $destination, $width, $height);

			$timestamp = time();
			$timeId = $id.'-' .$timestamp ;
		    $destination = UPLOAD_DIR . $timeId . '.png';
		    uploadImageAs8BitPNG($imgData, $destination, $width, $height);

		   	return array("name" => $timeId,  "user"=> $id, "timestamp" => $timestamp, "uploadDir" => UPLOAD_DIR_ABS);
		}
	 }

	 function setActive($name) {
	 	$user = explode("-",$name)[0];
		if (exif_imagetype(UPLOAD_DIR . $name . '.png') == IMAGETYPE_PNG) {
			try {
				unlink(UPLOAD_DIR . $user . '.png');
			} catch(Exeption $e){ }
			try {
				copy(UPLOAD_DIR . $name . '.png',UPLOAD_DIR . $user .'.png');
			} catch(Exeption $e){ }
			return array("name" => $name . '.png',  "user"=> $user, "timestamp" => explode("-",$name)[1], "uploadDir" => UPLOAD_DIR_ABS);
		} else {
			return array("name" => null,  "user"=> $user, "timestamp" => null, "uploadDir" => null);
		}
	 }

	 function deleteImage($name) {
	 	$name .= '.png';
		if (exif_imagetype(UPLOAD_DIR . $name) == IMAGETYPE_PNG) {
				unlink(UPLOAD_DIR . $name);
		}
	 }

}