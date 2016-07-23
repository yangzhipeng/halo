<?php

$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken ) {
	$file_name = $_FILES['Filedata']['name'];
	$pt=strrpos($file_name, ".");
	if ($pt) {
		$extension=substr($file_name, $pt+1, strlen($file_name) - $pt);
		$extension = strtolower($extension);
	}

	$newImagefileName = 'notice.imageurl.upload.' .
		strtotime(date('Y-m-d H:i:s')).
		'.'.md5(substr($file_name, 0, strrpos($file_name, '.'))).$extension;

	$newFilePath = 'storage/uploads/'.$newImagefileName;

	$newFilePath = $_SERVER['DOCUMENT_ROOT'].'/'.$newFilePath;

	$newImageMd5 = md5($newFilePath);

	$tempFile = $_FILES['Filedata']['tmp_name'];

	$targetPath = 'notice/image'. date('/Y/m/d/');
	$targetFile = rtrim($targetPath,'/') . '/' .$newImageMd5.'.'. $extension;
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$newFilePath);
		echo $targetFile.';'.$newFilePath;
	} else {
		echo 0;
	}
}
?>