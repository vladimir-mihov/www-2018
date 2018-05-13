<?php
	require_once('session.php');
	$_SESSION['uid'] = 0;
	header( 'Location: //' . $srvr, true, 302 );
	die();
?>