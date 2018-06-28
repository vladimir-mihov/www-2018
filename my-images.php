<?php
	require_once('session.php');
	require_once('database.php');

	$db = new database();
	$getMyImages = $db->query( "SELECT * FROM images WHERE ownerID=$_SESSION[uid]" );
	$myImages = $getMyImages->fetchAll( PDO::FETCH_ASSOC );
	$getUsername = $db->query( "SELECT * FROM users WHERE userID=$_SESSION[uid]" );
	$username = $getUsername->fetch()['uname'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf8'>
		<link href='styles/reset.css' rel='stylesheet'>
		<link href='styles/core.css' rel='stylesheet'>
		<link href='styles/index.css' rel='stylesheet'>
		<title>Imgur copy</title>
	</head>
	<body>
		<?php require_once('nav.php'); ?>
		<main class='images'>
			<?php if( count($myImages) ): ?>
			<p class='header'><?= $username ?>'s images</p>
			<?php else: ?>
			<p class='header'>No images found</p>
			<?php endif; ?>
			<?php foreach( $myImages as $image ): ?>
			<a href='i/<?= $image['name'] ?>'><img src='uploads/<?= $image['name'] ?>' class='image'/></a>
			<?php endforeach; ?>
		</main>
	</body>
</html>
