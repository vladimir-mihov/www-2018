<?php
	session_start();
	if( !isset($_SESSION['uid']) ) {
		$_SESSION['uid'] = 0;
	}
	$srvr = $_SERVER['SERVER_NAME'];
?>
