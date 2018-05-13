<?php
	require_once('session.php');
	require_once('database.php');

	if( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		$uploadDir = 'uploads/';
		$uploadFile = $uploadDir . basename( $_FILES['file']['name'] );
		$fileName = basename( $uploadFile );
		if( file_exists( $uploadFile ) ) {
			echo $fileName;
			die();
		}
		$imageFileType = strtolower( pathinfo( $uploadFile,PATHINFO_EXTENSION ) );
		if( ($imageFileType === 'png' || $imageFileType === 'jpg') and move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile) ) {
			$db = new database('images','root','');
			$insertImage = $db->prepare( "INSERT INTO img(imagelink,ownerID) VALUES(:imageName,:uid)" );
			$uid = $_SESSION['uid'] !== 0 ? $_SESSION['uid'] : 2;
			$insertImage->bindParam( ':imageName', $fileName );
			$insertImage->bindParam( ':uid', $uid );
			$insertImage->execute();
			echo $fileName;
		}
		die();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link href='styles/reset.css' rel='stylesheet'>
		<link href='styles/core.css' rel='stylesheet'>
		<link href='styles/upload.css' rel='stylesheet'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<title>Imgur copy</title>
	</head>
	<body>
		<?php require_once( 'nav.php' ); ?>
		<form enctype='multipart/form-data' method='post' name='upload' id='upload-form'>
			<div id='drop-container'>
				<div id='drop-area'>
					<span id='drop-text'>Drop files here.</span>
				</div>
			</div>
			<input type='hidden' name='MAX_FILE_SIZE' value='30000'>
			<input type='file' name='file' id='file'>
			<input type='button' name='file-button' id='file-button' value='Choose a file'>
			<input type='submit' 
			value='Upload'>
		</form>
		<script src='js/upload.js'></script>
	</body>
</html>