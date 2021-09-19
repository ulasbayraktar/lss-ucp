<?php 
	if(!isset($_SESSION['is_logged']))
	{
		exit(header("Location: index.php?page=home"));
	}

	if(isset($_GET['msg']))
	{
		if(empty($_GET['msg'])) 
        {
        	exit(header("Location: index.php?page=mb"));
        }
        else if(!$user->GetUCPMsg($_GET['msg'], 'id'))
        {
        	exit(header("Location: index.php?page=mb"));
        }
        else if($user->GetUCPMsg($_GET['msg'], 'to_id') != $_SESSION['account_id'])
        {
        	exit(header("Location: index.php?page=mb"));
        }
        else
        {
    		echo '
				<div class="cont">
					<br><font size="2">
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
				   		<a href="index.php?page=cp">Kontrol Paneli</a> 
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
				   		<a href="index.php?page=mb">Gelen Kutusu</a> 
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
				   		Özel Mesaj
				   	</font><br><br>
			';   	
				   	
			if(!$user->GetUCPMsg($_GET['msg'], 'is_read'))
			{	
				$user->SetUCPMsg($_GET['msg'], 'is_read', 1);

				echo '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;"> 
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
							Bu mesaj okundu olarak işaretlendi.
						</p>
					</div>
					<br>
				';
			}

			$stmt = $db->connect()->prepare("SELECT * FROM ucp_mailboxes WHERE id = ?"); $stmt->execute([$_GET['msg']]);
		   	while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
		   	{
		      	echo '
					<font size="5">&raquo; '.$rows['msg_title'].'</font><br><br>	
					<div id="argh" style="margin-top: 5px; background-color: #e8eff6; border: 1px dashed #DFDFDF; width: 730px; text-align: left; padding:5px;">
						<table width="100%">
							<tbody>
								<tr>
									<td width="8%"><img src="images/go_friend.gif" width="11"> <b>Başlık:</b></td>
									<td>'.$rows['msg_title'].'</td>
								</tr>
								<tr>
									<td width="8%"><img src="images/go_friend.gif" width="11"> <b>Gönd.:</b></td>
									<td>'.$user->getAdminName($rows['from_id']).'</td>
								</tr>
								<tr>
									<td width="8%"><img src="images/go_friend.gif" width="11"> <b>Tarih:</b></td>
									<td>'.$time->GetFullTime($rows['time']).'</td>
								</tr>
							</tbody>
						</table><br>
						'.$rows['msg_content'].'

						<br><br>
					</div>
		      	';
		   	}
			echo '</div>';
        }
	}
	else
	{
		if(isset($_GET['rm']))
		{
	        if(empty($_GET['rm'])) 
	        {
	        	exit(header("Location: index.php?page=mb"));
	        }
	        else if(!$user->GetUCPMsg($_GET['rm'], 'id'))
	        {
	        	exit(header("Location: index.php?page=mb"));
	        }
	        else if($user->GetUCPMsg($_GET['rm'], 'to_id') != $_SESSION['account_id'])
	        {
	        	exit(header("Location: index.php?page=mb"));
	        }
	        else
	        {
	        	$user->DeleteUCPMsg($_GET['rm']);
	        	//header("Refresh: 2; URL=index.php?page=mb");
	        	
				$hata = '
					<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
							Seçtiğiniz mesaj başarıyla silindi.
						</p>
					</div>
					<br>
	        	';
	        }
		}

		$mb_count = $user->GetAllUCPMsgs($_SESSION['account_id']);
		$mb_unread_count = $user->GetAllUnreadUCPMsgs($_SESSION['account_id']);

		echo '
			<div class="cont">
			   	<br><font size="2">
			   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
			   		<a href="index.php?page=cp">Kontrol Paneli</a> 
			   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
			   		Gelen Kutusu
			   	</font>
			   	<br><br><font size="5">&raquo; Gelen Kutusu</font><br><br>
			   	'.$hata.'
				<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Gelen kutunuzda izin verilen toplam 10.000 mesaj içinden <b>'.$mb_count.'</b> adet mesaj var.
						<b>'.$mb_unread_count.'</b> adet okunmamış mesaj var.
					</p>
				</div>
				<br>
				<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<td width="40%">
						<b>Konu</b>
					</td>
					<td width="25%">
						<b>Gönderen</b>
					</td>
					<td width="25%">
						<b>Tarih</b>
					</td>
					<td width="10%">
						<b></b>
					</td>
				</tr>';

				$stmt = $db->connect()->prepare("SELECT * FROM ucp_mailboxes WHERE to_id = ?"); 
				$stmt->execute([$_SESSION['account_id']]);

			   	while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
			   	{
			      	echo '
						<tr style="font-size: 11px; cursor: pointer;" onclick="window.location =  \'index.php?page=mb&msg='.$rows['id'].'\';" onmouseover="this.style.backgroundColor=\'lightblue\';" onmouseout="this.style.backgroundColor = \'white\';">
							<td>
								<img src="images/read_msg.png" style="margin: 0px 0px -3px;"> '.$rows['msg_title'].'
							</td>
							<td>'.$user->getAdminName($rows['from_id']).'</td>
							<td>'.$time->GetFullTime($rows['time']).'</td>
							<td>
								<a href="index.php?page=mb&rm='.$rows['id'].'">
								<img src="images/del_friend.gif" width="14" title="Bu mesajı sil" />
								</a>
							</td>
						</tr>
			      	';
			   	}

			echo '
				</table><br><br><br></div>
			';

	}
?>			