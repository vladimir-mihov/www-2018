<?php
	require_once('session.php');
	require_once('database.php');

	$db = new database('images','root','');
	$getUsername = $db->prepare( "SELECT * FROM users WHERE userID=:uid" );
	$guestUserId = 2;
	if( $_SESSION['uid'] /*> 0*/ ) {
		$getUsername->bindParam( ':uid', $_SESSION['uid'] );
	} else {
		$getUsername->bindParam( ':uid', $guestUserId );
	}
	$getUsername->execute();
	$username = $getUsername->fetch()['user'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Imgur copy</title>
	<link href='styles/reset.css' rel='stylesheet'>
	<link href='styles/core.css' rel='stylesheet'>
	<link href='styles/profile.css' rel='stylesheet'>
</head>
<body>
	<?php
		require_once('nav.php');
	?>
	<main id='content'>
		<section id='left' class='left'>
			<img src='images/4head.png'>
			<div class='info'>
				<p><?= $username ?></p>
			</div>
		</section>
		<section id='right' class='right'>
			<ul>
				<li><a href='#' class='profile-link'>Change password</a></li>
				<li><a href='#' class='profile-link'>Change profile image</a></li>
				<li><a href='my-images' class='profile-link'>View my albums</a></li>
			</ul>
		</section>
	</main>
</body>
</html>