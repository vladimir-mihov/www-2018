<?php
	if( $_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['uid']) && isset($_POST['vote']) ) {
		require_once( 'database.php' );
		$db = new database('images','root','');
		$checkIfUserHasVoted = $db->prepare( "SELECT * FROM votes WHERE imageID=:imageid AND fromUserID=:uid" );
		$checkIfUserHasVoted->bindParam( ':imageid', $_POST['imageid'] );
		$checkIfUserHasVoted->bindParam( ':uid', $_POST['uid'] );
		$checkIfUserHasVoted->execute();
		if( !empty($checkIfUserHasVoted->fetch()) ) {
			$removeOldVote = $db->prepare( "DELETE FROM votes WHERE imageID=:imageid AND fromUserID=:uid" );
			$removeOldVote->bindParam( ':uid', $_POST['uid'] );
			$removeOldVote->execute();
		}
		$insertNewVote = $db->prepare( "INSERT INTO votes VALUES(:imageid,:uid,:vote)" );
		$insertNewVote->bindParam( ':imageid', $_POST['imageid'] );
		$insertNewVote->bindParam( ':uid', $_POST['uid'] );
		$insertNewVote->bindParam( ':vote', $_POST['vote'] );
		$insertNewVote->execute();
	}
?>