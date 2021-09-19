<?php
	if(!isset($_SESSION['is_logged']))
	{
		exit(header("Location: index.php?page=home"));
	}

	$user->OnAccountDisconnect();

	echo '
		<div class="cont">
			<br><br><br><br>
			<center><b><font size="4">Başarıyla çıkış yaptınız.<br><br><img src="images/preload.gif"></font></b></center>
		</div>
		<meta http-equiv="refresh" content="2; URL=index.php?page=home">
	';
?>