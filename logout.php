<?php
	require_once('session.php');
	session_destroy();
	header( 'Location: //' . $srvr, true, 302 );
	die();
?>
