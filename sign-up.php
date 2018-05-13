<?php
	require_once('session.php');
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$userRegex = '/^[a-zA-Z_][a-zA-Z0-9_]{5,63}$/';
		$pwdRegex = '/^.{6,64}$/';
		$emailRegex = '/(?=^.{0,64}$)^\w+@[a-zA-Z]+\.[a-zA-Z]+$/';
		$err = false;
		require_once( 'database.php' );
		$db = new database( 'images', 'root', '' );
		if( !preg_match($userRegex, $_POST['user']) ||
			!preg_match($pwdRegex, $_POST['pwd']) ||
			!preg_match($pwdRegex, $_POST['cpwd']) ||
			!preg_match($emailRegex, $_POST['email']) )
			$err = true;
		if( !$err ) {
			$checkIfUserExists = $db->prepare( 'SELECT * FROM users WHERE user=:user' );
			$checkIfUserExists->bindParam( ':user', $_POST['user'] );
			$checkIfUserExists->execute();
			if( !empty($checkIfUserExists->fetch()) ) {
				header( 'Location: sign-up' );
				die();
			}
			
			$insert = $db->prepare( 'INSERT INTO users(user, pwd, email) VALUES (:user, :pwd, :email)' );
			$pwdHash = password_hash( $_POST['pwd'], PASSWORD_DEFAULT );
			$insert->bindParam( ':user', $_POST['user'] );
			$insert->bindParam( ':pwd', $pwdHash );
			$insert->bindParam( ':email', $_POST['email'] );
			$insert->execute();
			header( 'Location: login' );
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
		<link href='styles/sign-up.css' rel='stylesheet'>
		<title>Imgur copy</title>
	</head>
	<body>
		<?php require_once( 'nav.php' ); ?>
		<section class='form-section'>
			<form method='post' name='sign-up' class='form' id='form'>
				<input type='text' name='user' autocomplete='off' spellcheck='false' id='user' placeholder='Username'>
				<div id='error-block' class='error'></div>
				<input type='password' name='pwd' autocomplete='off' spellcheck='false' id='pwd' placeholder='Password'>
				<input type='password' name='cpwd' autocomplete='off' spellcheck='false' id='cpwd' placeholder='Confirm password'>
				<input type='text' name='email' autocomplete='off' spellcheck='false' id='email' placeholder='E-mail'>
				<input type='submit' id='submit' value='Sign-up'>
				<span id='acc'>Already have an account? <a href='login' class='bold'>Login.</a></span>
			</form>
		</section>
		<script src='js/sign-up.js'></script>
	</body>
</html>