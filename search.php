<?php
    require_once('session.php');
    require_once('database.php');

    if( !empty($_GET['query']) ) {
        $db = new database('images','root','');
        $getImageData = $db->query( "SELECT name, tags FROM images" );
        $rawData = $getImageData->fetchAll( PDO::FETCH_ASSOC );

        $imageData = array();

        foreach( $rawData as $image ) {
        	$imageData[$image['name']] = explode( ',', $image['tags'] );
        }

        $searchTags = explode( ',', $_GET['query'] );
        $foundImages = array();

        foreach( $imageData as $imageName => $tags ) {
            if( array_intersect($tags,$searchTags) ) {
                $foundImages[] = $imageName;
            }
        }
    } else {
        http_response_code(400);
        die();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
		<link href='//<?= $srvr ?>/styles/reset.css' rel='stylesheet'>
		<link href='//<?= $srvr ?>/styles/core.css' rel='stylesheet'>
		<link href='//<?= $srvr ?>/styles/index.css' rel='stylesheet'>
        <title>Imgur copy</title>
    </head>
    <body>
        <?php require_once('nav.php'); ?>
        <main class='images'>
            <?php foreach( $foundImages as $image ): ?>
                <a href='//<?= $srvr ?>/i/<?= $image ?>'><img src='//<?= $srvr ?>/uploads/<?= $image ?>' class='image'/></a>
            <?php endforeach; ?>
        </main>
    </body>
</html>
