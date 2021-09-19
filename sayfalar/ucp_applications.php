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

<div class="cont">
	<br>
    <div class="s-title">
    	<a name="arecord">
      	UCP Hesapları
    </div>
    <br>
    <a href="index.php?page=ucp_applications"><input type="submit" class="black_button" value="Tüm Liste"></a>
    <a href="index.php?page=ucp_applications&type=adminlevel"><input type="submit" class="black_button" value="Yöneticiler"></a>
    <a href="index.php?page=ucp_applications&type=testerlevel"><input type="submit" class="black_button" value="Testerlar"></a>

    <table class="app_table tablesorter" border="0" cellpadding="0" cellspacing="1">
	  	<thead>
	     	<tr>
	     		<th>#</th>
	     		<th>UCP ADI</th>
	        	<th>KAYIT TARIHI</th>
	        	<th>İŞLEMLER</th>
	    	</tr>
	  	</thead>
	  	<tfoot>
	  	<?php
	  	$siralama_turu = $_GET['type'];
	  	if($siralama_turu) $stmt = $db->connect()->prepare("SELECT * FROM accounts WHERE ".$siralama_turu." > 0");
	  	else $stmt = $db->connect()->prepare("SELECT * FROM accounts");
		$stmt->execute();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$img = $row['adminlevel'] ? '<img class="info_tooltip" title="'.$row['adminlevel'].' seviye yönetici" src="./images/staff.gif">' : '';
			$status = $row['is_logged'] ? "green" : "red";
			$online_status = $user->GetPlayer($rows['active_id'], 'IsOnline') ? '<img class="info_tooltip" title="bu kişi şu anda oyunda!" src="./images/active.jpg">' : '';

			echo '
				<tr>
					<th>'.$row['id'].'</th>
					<th><font color="'.$status.'">'.$img.' '.$row['name'].' ('.$row['email'].') '.$online_status.'</font></th>
					<th>'.$time->GetFullTime($row['reg_time']).'</th>
					<th><a href="index.php?page=ucp_applications&id='.$row['id'].'">INCELE</a></th>
				</tr>
			';
		}
	  	?>
		</tfoot>
		<tbody></tbody>
  	</table>
  	<br><br>
  	<br><br>
</div>
