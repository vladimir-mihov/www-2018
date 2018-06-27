<?php
	require_once('session.php');
	require_once('database.php');

	$db = new database( 'images', 'root', '' );
	$result = $db->query( 'SELECT * FROM images' );
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
		<?php while( $row = $result->fetch(PDO::FETCH_ASSOC) ): ?>
			<a href='i/<?= $row['name'] ?>'><img src='uploads/<?= $row['name'] ?>' class='image'/></a>
		<?php endwhile; ?>
		</main>
	</body>
</html>
