<?php
	require_once('session.php');
	require_once('database.php');

	$db = new database( 'images', 'root', '' );
	$images = $db->query( 'SELECT name FROM images' )->fetchAll( PDO::FETCH_ASSOC );
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link href='styles/reset.css' rel='stylesheet'>
		<link href='styles/core.css' rel='stylesheet'>
		<link href='styles/index.css' rel='stylesheet'>
		<title>Imgur copy</title>
	</head>
	<body>
		<?php require_once('nav.php'); ?>
		<main class='images'>
		<?php if( empty($images) ): ?>
			<p class='header'>No images found</p>
		<?php endif; ?>
		<?php foreach( $images as $image ): ?>
			<a href='i/<?= $image['name'] ?>'><img src='uploads/<?= $image['name'] ?>' class='image'/></a>
		<?php endforeach; ?>
		</main>
	</body>
</html>
