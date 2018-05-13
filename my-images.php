<?php
	require_once('session.php');
	require_once('database.php');

	$db = new database( 'images', 'root', '' );
	$getMyImages = $db->query( "SELECT * FROM img WHERE ownerID=$_SESSION[uid]" );
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf8'>
		<link href='styles/reset.css' rel='stylesheet'>
		<link href='styles/core.css' rel='stylesheet'>
		<link href='styles/index.css' rel='stylesheet'>
		<title>Imgur copy</title>
		<style>
			.no-images {
				font-size: 2em;
				text-align: center;
				color: #fff;
			}
		</style>
	</head>
	<body>
		<?php require_once('nav.php'); ?>
		<main class='images'>
			<?php if( $row = $getMyImages->fetch(PDO::FETCH_ASSOC) ): ?>
			<a href='i/<?= $row['imagelink'] ?>'><img src='uploads/<?= $row['imagelink'] ?>' class='image'/></a>

			<?php while( $row = $getMyImages->fetch(PDO::FETCH_ASSOC) ): ?>
			<a href='i/<?= $row['imagelink'] ?>'><img src='uploads/<?= $row['imagelink'] ?>' class='image'/></a>
			<?php endwhile; ?>
			<?php else: ?>
			<p class='no-images'>No images found.</p>
			<?php endif; ?>
		</main>
	</body>
</html>