<?php
	require_once('session.php');
	if( !file_exists( 'uploads/' . $_GET['image']) ) {
		header( 'Status: 404 Not Found', true, 404 );
		require_once( '404.php' );
		exit();
	}
	require_once('database.php');

	$db = new database();

	$image = $db->prepare( 'SELECT imageID, ownerID, tags FROM images WHERE name=:imagename' );
	$image->bindParam( ':imagename', $_GET['image'] );
	$image->execute();
	$imageData = $image->fetch();
	$imageID = $imageData['imageID'];
	$imageOwnerID = $imageData['ownerID'];
	$imageTags = explode( ',', $imageData['tags'] );

	if( $_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['uid'] ) {
		if( $_POST['action'] === 'comment' ) {
			$comment = $db->prepare( "INSERT INTO comments( userID, imageID, comment ) VALUES ( :uid, $imageID, :comment )");
			$comment->bindParam( ':uid', $_SESSION['uid'] );
			$comment->bindParam( ':comment', $_POST['comment'] );
			$comment->execute();
		} else if( $_POST['action'] === 'controls' ) {
			$checkIfUserHasVoted = $db->prepare( "SELECT * FROM votes WHERE imageID=:imageid AND userID=:uid" );
			$checkIfUserHasVoted->bindParam( ':imageid', $imageID );
			$checkIfUserHasVoted->bindParam( ':uid', $_SESSION['uid'] );
			$checkIfUserHasVoted->execute();
			if( !empty($checkIfUserHasVoted->fetch()) ) {
				$updateVote = $db->prepare( "UPDATE votes SET vote=:vote WHERE imageID=:imageid AND userID=:uid" );
				$updateVote->bindParam( ':imageid', $imageID );
				$updateVote->bindParam( ':uid', $_SESSION['uid'] );
				$updateVote->bindParam( ':vote', $_POST['pressedButton'] );
				$updateVote->execute();
			} else {
				$insertNewVote = $db->prepare( "INSERT INTO votes VALUES(:imageid,:uid,:vote)" );
				$insertNewVote->bindParam( ':imageid', $imageID );
				$insertNewVote->bindParam( ':uid', $_SESSION['uid'] );
				$insertNewVote->bindParam( ':vote', $_POST['pressedButton'] );
				$insertNewVote->execute();
			}
		} else if( $_POST['action'] === 'remove' ) {
			if( $imageOwnerID == $_SESSION['uid'] || $_SESSION['privilege'] ) {
				$removeImage = $db->query( "DELETE FROM images WHERE imageID=$imageID" );
				unlink( 'uploads/' . $_GET['image'] );
				header( "Location: //$srvr/my-images");
			}
		}
	}

	$imageComments = $db->query( "SELECT comment FROM comments WHERE imageID=$imageID" );
	$vote = $db->query( "SELECT * FROM votes WHERE imageID=$imageID AND userID=$_SESSION[uid]" )->fetch();
	$hasVoted = !empty( $vote );

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>
		<link href='//<?= $srvr ?>/styles/reset.css' rel='stylesheet'>
		<link href='//<?= $srvr ?>/styles/core.css' rel='stylesheet'>
		<link href='//<?= $srvr ?>/styles/img.css' rel='stylesheet'>
		<title>Imgur copy</title>
		<script type='text/javascript'>
			<?php if( $hasVoted ): ?>
			var voted = <?php echo $vote['vote'] ?>;
			<?php else: ?>
			var voted = undefined;
			<?php endif; ?>
		</script>
	</head>
	<body>
		<?php require_once( 'nav.php' ); ?>
		<main class='content'>
			<img src='//<?= $srvr ?>/uploads/<?= $_GET['image'] ?>' class='main-image'/>
			<?php if( $_SESSION['uid'] ): ?>
			<form method='post' class='buttons' id='controls'>
				<input type='hidden' name='action' value='controls'>
				<input type='hidden' name='pressedButton'>
				<button id='thumbsUp' class='button'><img src='//<?= $srvr ?>/images/thumbs-up<?php if( $hasVoted && $vote['vote'] ): ?>-green<?php endif; ?>.png'></button>
				<button id='thumbsDown' class='button'><img src='//<?= $srvr ?>/images/thumbs-down<?php if( $hasVoted && !$vote['vote'] ): ?>-red<?php endif; ?>.png'></button>
				<?php if( $_SESSION['uid'] == $imageOwnerID || $_SESSION['privilege'] ): ?>
				<button id='removeDummy' class='button'><img src='//<?= $srvr ?>/images/delete.png'></button>
				<?php endif; ?>
			</form>
			<?php if( $_SESSION['uid'] === $imageOwnerID || $_SESSION['privilege']): ?>
			<form method='post' id='removeForm'>
				<input type='hidden' name='action' value='remove'>
				<p>Are you sure that you want to delete this image?</p>
				<button id='remove'>Delete</button>
			</form>
			<div id='curtain'></div>
			<?php endif; ?>
			<section id='tags'>
				<p>Tags</p>
				<ul>
				<?php foreach( $imageTags as $tag ): ?>
					<li class='tag'><?= $tag ?></li>
				<?php endforeach; ?>
				</ul>
			</section>
			<form id='commentForm' method='post' name='addComment'>
				<input type='hidden' name='action' value='comment'>
				<input type='text' name='comment' autocomplete='off'>
				<input type='submit' name='submitComment' value='COMMENT'>
			</form>
			<?php endif; ?>
			<section class='comments'>
				<ul>
					<?php while($row = $imageComments->fetch(PDO::FETCH_ASSOC)): ?>
					<li><?= $row['comment'] ?></li>
					<?php endwhile; ?>
				</ul>
			</section>
		</main>
		<script src='//<?= $srvr ?>/js/img.js'></script>
	</body>
</html>
