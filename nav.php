<?php
	require_once('session.php');
?>

<nav>
	<ul>
		<li><a href='//<?= $srvr ?>'><img src='//<?= $srvr ?>/images/logo.png' id='logo'/></a></li>
		<li><a href='//<?= $srvr ?>/upload'>Upload</a></li>
		<li id='separator'></li>
		<?php if( !$_SESSION['uid'] ): ?>
		<li><a href='//<?= $srvr ?>/login'>Login</a></li>
		<li><a href='//<?= $srvr ?>/sign-up'>Sign-up</a></li>
		<?php else: ?>
		<li><img src='//<?= $srvr ?>/images/4head.png' id='userIcon' class='userIcon'></li>
		<li><img src='//<?= $srvr ?>/images/burger.png' id='menuIcon' class='menuIcon'></li>
		<?php endif; ?>
	</ul>
</nav>
<div id='menu' class='menu'>
	<ul>
		<li id='profile' >Profile</a></li>
		<li id='my-images'>My Images!<strike>Albums</strike></li>
		<li id='upgrade'>Upgrade to Imgur!</li>
		<li id='logout'>Logout</li>
	</ul>
</div>
<script src='//<?= $srvr ?>/js/core.js'></script>
