<?php
	if(!$_SESSION['is_logged'])
  	{
    	exit(header("Location: index.php?page=home"));
  	}

  	if(!$_SESSION['is_admin'])
  	{
    	exit(header("Location: index.php?page=cp"));
  	}
?>
this is admin area