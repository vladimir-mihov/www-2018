<?php
	require_once('session.php');
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		require_once( 'database.php' );
		$db = new database( 'images', 'root', '' );
		$err = '';
		
		$getUserData = $db->prepare( "SELECT * FROM users WHERE user=:user" );
		$getUserData->bindParam( ':user', $_POST['user'] );
		$getUserData->execute();
		$userData = $getUserData->fetch( PDO::FETCH_ASSOC );
		
		if( !empty($userData) and password_verify( $_POST['pwd'], $userData['pwd'] ) ) {
			$_SESSION['uid'] = $userData['userID'];
			header( "Location: http://$_SERVER[SERVER_NAME]", true, 302 );
			die();
		} else {
			$err = 'Wrong username/password combination!';
			echo $err;
			die();
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link href='styles/reset.css' rel='stylesheet'>
		<link href='styles/core.css' rel='stylesheet'>
		<link href='styles/login.css' rel='stylesheet'>
		<title>Imgur copy</title>
	</head>
	<body>
		<?php require_once( 'nav.php' ); ?>
		<section class='form-section'>
			<form method='post' name='login' class='form'>
				<input type='text' name='user' autocomplete='off' spellcheck='false' id='user' placeholder='Username'><!-- class = flash-red if $err is set -->
				<input type='password' name='pwd' autocomplete='off' spellcheck='false' id='pwd' placeholder='Password'>
				<input type='submit' value='Login'>
				<span id='acc'>Don't have an account? <a href='sign-up' class='bold'>Sign-up.</a></span>
			</form>
		</section>
		<script> </script>
	</body>
</html>