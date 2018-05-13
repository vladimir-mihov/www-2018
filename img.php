<?php
	require_once('session.php');
	if( !file_exists( 'uploads/' . $_GET['image']) ) {
		header( 'Status: 404 Not Found', true, 404 );
		require_once( '404.php' );
		exit();
	}
	require_once('database.php');
	
	$db = new database('images','root','');
	
	$image = $db->prepare( 'SELECT ID FROM img WHERE imagelink=:imglink' );
	$image->bindParam( ':imglink', $_GET['image'] );
	$image->execute();
	$imageID = $image->fetch()['ID'];
	
	if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
		$comment = $db->prepare( "INSERT INTO comments( userID, commentOf, comment ) VALUES ( :uid, $imageID, :comment )");
		$uid = 1;
		$comment->bindParam( ':uid', $uid );
		$comment->bindParam( ':comment', $_POST['comment'] );
		$comment->execute();
	}
	
	$imageComments = $db->query( "SELECT comment FROM comments WHERE commentOf=$imageID" );
	$vote = $db->query( "SELECT * FROM votes WHERE imageID=$imageID AND fromUserID=" . ($_SESSION['uid'] /* > 0 */ ? $_SESSION['uid'] : 2) )->fetch();
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
			var uid = <?php echo $_SESSION['uid'] ?>;
			var imageid = <?php echo $imageID ?>;
			<?php if( $hasVoted ): ?>
			var voted = <?php echo $vote['vote'] ?>;
			<?php endif; ?>
		</script>
	</head>
	<body>
		<?php require_once( 'nav.php' ); ?>
		<main class='content'>
			<img src='//<?= $srvr ?>/uploads/<?= $_GET['image'] ?>' class='main-image'/>
			<div class='buttons'>
				<button id='thumbsUp' class='button'><img src='//<?= $srvr ?>/images/thumbs-up.png'></button>
				<button id='thumbsDown' class='button'><img src='//<?= $srvr ?>/images/thumbs-down.png'></button>
				<button id='report' class='button'><img src='//<?= $srvr ?>/images/flag.png'></button>
			</div>
			<form id='commentForm' method='post' name='addComment'>
				<input type='text' name='comment' autocomplete='off'>
				<input type='submit' name='submitComment' value='COMMENT'>
			</form>
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