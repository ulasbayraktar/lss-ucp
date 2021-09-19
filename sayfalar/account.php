<?php
	if(!$_SESSION['is_logged'])
  	{
    	exit(header("Location: index.php?page=home"));
  	}
?>

<div class="cont">
	<br><font size="2">
   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
   		<a href="index.php?page=cp">Kontrol Paneli</a> 
   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
   		UCP Ayarları
   	</font><br><br>
   	<font size="5">&raquo; UCP Ayarları</font><br>
   	<br><br>
   	<?php

   	echo $hata;

   	echo '
	<div class="tab_style">
		<ul>
			<li class="disabled"><a href="#general"><span>Genel</span></a></li>
            <li><a href="#profile"><span>Bilgilendirme</span></a></li>
            <li><a href="#changepw"><span>E-posta/Şifre Değiştir</span></a></li>
            <li><a href="#changemem"><span>Güvenlik Kelimesini Değiştir</span></a></li>
		</ul>
		<div id="general">
			<form method="post">
				<table width="100%">
				<tr>
					<td width="40%">
						<b>Önemli e-postaları al:</b>
					</td>
					<td width="80%">
						<input type="checkbox" name="notify" disabled / >
					</td>
				</tr>
                <tr>
					<td width="40%">
						   <b>UCP Tasarımı:</b>
					</td>
					<td width="80%">
						<select name="design" disabled>
							<option value="ui-darkness" selected>Default</option>
							<option value="dark-hive" >Dark Hive</option>
							<option value="le-frog" >Le Frog</option>	
							<option value="mint-choc" >Mint Choc</option>
							<option value="vader" >Vader</option>
							<option value="trontastic" >Trontastic</option>
							<option value="swanky-purse" >Swanky Purse</option>
							<option value="greenie" >Greenie</option>
						</select>
					</td>
				</tr>
				<tr>
					<td width="40%">
						<input type="submit" name="save_general" class="black_button" value="Ayarları Kaydet" / >
					</td>
				</tr>
				</table>
			</form>
		</div>

		<div id="profile">
			<br>
			<table width="100%">
				<tr>
					<td width="40%">
						<b>Kayıt ID:</b>
					</td>
					<td width="80%">
						'.$_SESSION['account_id'].'
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>Google Auth:</b>
					</td>
					<td width="80%">
						<i>Yakında...</i>
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>IP adresi:</b>
					</td>
					<td width="80%">
						'.$_SERVER["REMOTE_ADDR"].'
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>Ülke kodu:</b>
					</td>
					<td width="80%">
				';
					$ip = $_SERVER["REMOTE_ADDR"];
					$url = file_get_contents("http://ip-api.com/json/$ip?fields=country,countryCode");
					$decode = json_decode($url, true);

					if($decode['country'] != "") {
						echo $decode['country'].' <img src="images/flags/'.strtolower($decode['countryCode']).'.png">';
					} else {
						echo 'Ülke kodu bulunamadı...';
					}
					
				echo '
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>E-posta adresi:</b>
					</td>
					<td width="80%">
						<a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="e380828d8a8ecd81868d8a8ecd808a808688d2a3848e828a8fcd808c8e">[email&#160;korumalı]</a>
					</td>
				</tr>
				<tr>
				';

				$slot = 1;
				$stmt = $db->connect()->prepare("SELECT id, Name FROM players WHERE AccountID = ?"); 
				$stmt->execute([$_SESSION['account_id']]);
				while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					echo '
					<td width="40%"><b>Karakter slotu '.$slot++.':</b></td>
						<td width="80%">'.$rows['Name'].' (Karakter ID #'.$rows['id'].')</td>
					</tr>
					';
				}
				echo '
			</table><br>
		<br><br>
		</div>
        <div id="changepw">
			<form method="post" autocomplete="off">
				<table width="100%">
					<tr>
						<td width="40%">
							<b>E-posta adresi:</b>
						</td>
						<td width="80%">
							   <input autocomplete="off" type="text" size="32" name="user_email" value="'.$user->GetAccount($_SESSION['account_name'], 'email').'">
						</td>
					</tr>
					<tr>
						<td width="40%">
							<b>Yeni şifre:</b>
						</td>
						<td width="80%">
							<input autocomplete="off" type="password" name="new_pass" size="48" value="" / >
						</td>
					</tr>
					<tr>
						<td width="40%">
							<b>Yeni şifre (tekrarı):</b>
						</td>
						<td width="80%">
							<input autocomplete="off" type="password" name="repeat_pass" size="48" value="" / >
						</td>
					</tr>
	                <tr>
	                    <td width="40%">
						</td>
						<td width="80%">
	                        <b>Bu ayarları kaydetmek için lütfen güvenlik yanıtınızı aşağıya girin:</b>
	                    </td>
	                </tr>
	                <tr>
						<td width="40%">
							<b>Güvenlik sorusu:</b>
						</td>
						<td width="80%">
							   <font color="grey">'.$user->GetAccount($_SESSION['account_name'], 'security_question').'</font>
						</td>
					</tr>
	                <tr>
						<td width="40%">
							<b>Güvenlik yanıtı:</b>
						</td>
						<td width="80%">
							   <input autocomplete="off" type="password" name="sec_answer" size="48" value="" / >
						</td>
					</tr>
					<tr>
						<td width="40%">
							<input type="submit" name="save_password" class="black_button" value="Ayarları Kaydet" / >
						</td>
					</tr>
				</table>
			</form>
		<br><br>
		<b>*</b> Bu <b>yalnızca</b> kullanıcı adı şifrenizi değiştirir ve karakterinizin şifresini etkilemez.
		</div>
        <div id="changemem">
			<form method="post">
				<table width="100%">
				<tr>
					<td width="40%">
						<b>Yeni gizli kelime: *</b>
					</td>
					<td width="80%">
						   <input autocomplete="off" type="text" name="new_mem" size="48" value="" / >
					</td>
				</tr>
				<tr>
					<td width="40%">
						<b>Yeni gizli kelime ipucusu: *</b>
					</td>
					<td width="80%">
						   <input autocomplete="off" type="text" name="new_hint" size="48" value="" / >
					</td>
				</tr>
                <tr>
	            <td width="40%">
					</td>
					<td width="80%">
	                    <b>Bu ayarları kaydetmek için lütfen güvenlik yanıtınızı aşağıya girin:</b>
	                </td>
	            </tr>
	            <tr>
					<td width="40%">
						<b>Güvenlik sorusu:</b>
					</td>
					<td width="80%">
						<font color="grey">'.$user->GetAccount($_SESSION['account_name'], 'security_question').'</font>
					</td>
				</tr>
	            <tr>
					<td width="40%">
						<b>Güvenlik yanıtı:</b>
					</td>
					<td width="80%">
						<input autocomplete="off" type="password" name="sec_answer" size="48" value="" / >
					</td>
				</tr>
				<tr>
					<td width="40%">
						<input type="submit" name="save_memorable" class="black_button" value="Ayarları Kaydet" / >
					</td>
				</tr>
				</table>
			</form>
		</div>			
	</div><br>
	';
	?>
</div>	
