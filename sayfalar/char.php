<?php
	if(!isset($_SESSION['is_logged']))
	{
		exit(header("Location: index.php?page=home"));
	}

	if(isset($_GET['action']))
	{
		$id = $_SESSION['account_id'];
		$_SESSION['player_id'] = $user->GetAccount($id, "active_id");
		switch($_GET['action'])
		{
			case 'unset':
			{
				$user->SetAccount($id, 'active_id', 0);
				$_SESSION['player_id'] = 0;

				echo '
	        		<div class="cont">
						<br><br><br><br>
						<center><img src="images/preload.gif"></center>
					</div>
					<meta http-equiv="refresh" content="2;URL=index.php?page=profile">
				';
				break;
			}
			case 'list':
			{
				if($_SESSION['player_id'] != 0)
				{
				 	exit(header("Location: index.php?page=profile"));
				}

				echo '
				<div class="cont">
					<br><font size="2">
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
				   		<a href="index.php?page=cp">Kontrol Paneli</a>
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
				   		<a href="index.php?page=char&action=info">Karakter</a>
				   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
				   		Karakter Listesi
				   	</font><br><br>
				   	<font size="5">&raquo; Karakter Listesi</font><br>
				   	<br>
				';

				$account_count = $user->GetAccountCount($_SESSION['account_id']);
				if($account_count)
				{
					$stmt = $db->connect()->prepare("SELECT * FROM players WHERE AccountID = ?");
					$stmt->execute([$_SESSION['account_id']]);

					echo 'Burada karakterlerinizden birisini seçebilirsiniz.
					Şu anda <b>'.$account_count.'</b> sayıda karakter(ler) hesabınızda bulunuyor.
					<br><br>';

					while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						echo '
							<form method="post" class="niceform">
								<font size="2"><input type="radio" onfocus="this.blur()" name="switch_char" id="'.$rows['id'].'" value="'.$rows['id'].'" />
									<label for="'.$rows['id'].'">
										<input type="text" name="username" id="username" size="40" maxlength="40" value="'.$rows['Name'].'" disabled />
									</label>
								</font>
								<br><br>
						';
					}

					echo '<input type="submit" name="switch_to" id="button" value="Karakteri Seç"></form>';
				}
				else
				{
					echo '
						<div class="error">
						<br>
							Üzgünüm, ama henüz karakteriniz yok. Aşağıdakileri yapabilirsin.
							<ul>
								<li>Karakter başvuru atabilirsin.</li>
							</ul>
						<br>
						</div>
					';
				}

				echo '</div>';
				break;
			}
			// Karakter aktarma kaldırıldı...
			//case 'export':
			//{
			//	if($_SESSION['player_id'] != 0)
			//	{
			//	 	exit(header("Location: index.php?page=profile"));
			//	}
			//	echo '
			//		<div class="cont">
			//			<br><font size="2">
			//		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
			//		   		<a href="index.php?page=cp">Kontrol Paneli</a>
			//		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
			//		   		<a href="index.php?page=char&action=info">Karakter</a>
			//		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
			//		   		Dışarı Aktar
			//		   	</font><br><br>
			//		   	<font size="5">&raquo; Karakter Dışarı Aktar</font><br><br>
			//		   	Karakter dışarı aktarma şuanlık pasif.
			//		</div>
			//	';
			//	break;
			//}
			case 'info':
			{
				if($_SESSION['player_id'] != 0)
				{
				 	exit(header("Location: index.php?page=profile"));
				}

				echo '
					<div class="cont">
						<br><font size="2">
					   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
					   		<a href="index.php?page=cp">Kontrol Paneli</a>
					   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
					   		Karakter
					   	</font>
					   	<br><br>
					   	<font size="5">&raquo; Karakter - Yeni ne var?</font>
					   	<br><br>
							<table>
								<tr>
									<td><b>Neler yeni?:</b><br>
									UCP ve anasayfa tek bir site haline geldi ve tamamen yeni bir tasarıma kavuştu. Kullanıcı paneli sıfırdan yeniden yazıldı. Çok fazla değişiklik ve yeni özellikler var, kendiniz kontrol edebilirsiniz.
									</td>
								</tr>
								<tr>
									<td><b>Yeni karakter nasıl oluşturulur?</b><br>
									LSS-RP\'de bir karakteriniz yoksa yeni bir karakter oluşturmanız gerekir. Bunu yapmak oldukça kolay. Karakter Oluştur\'a tıklayın, ardından karakterinizin adını yazın. Karakter adı Ad_Soyad şeklinde olmalıdır (Büyük harfleri ve alt çizgiyi dikkate alın). Sunucumuzda oynamanız için bir karaktere sahip olmanız gerekir.
									</td>
								</tr>
								<tr>
									<td><b>UCP\'deki karakterler arasında nasıl geçiş yapılır?</b><br>
									Birden fazla karakteriniz varsa, elbette skin ve spawn noktanızı değiştirmek isteyeceksiniz. Bunu yapmak için sağ taraftaki "Karakter Listesi"ni tıklayın. Daha sonra karakterlerinizin bir listesini göreceksiniz. Değiştirmek istediğiniz karaktere tıklayın ve düzenleyin!
									</td>
								</tr>
							</table>
							<br><br>
					</div>
				';
				break;
			}
			case 'new':
			{
				if($_SESSION['player_id'] != 0)
				{
				 	exit(header("Location: index.php?page=profile"));
				}

				if(isset($_POST['submit_application']))
				{
					$karakter_adi = htmlspecialchars(trim($_POST['rpname']));
					$dogum_yeri = htmlspecialchars(trim($_POST['origin']));
					$yas = htmlspecialchars(trim($_POST['age']));

					$hikaye = htmlspecialchars(trim($_POST['story']));
					$arkaplan = htmlspecialchars(trim($_POST['background']));
					$politika = htmlspecialchars(trim($_POST['policy']));
					$terim = htmlspecialchars(trim($_POST['terms']));

					if(empty($karakter_adi) || empty($dogum_yeri) || empty($yas) || empty($hikaye) || empty($arkaplan) || empty($politika) || empty($terim))
			        {
			        	$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Tüm gerekli alanları doldurunuz.
								</p>
							</div>
							<br><br>
						';
					}
					else if(!preg_match('#^[a-zA-Z1-9]+_[a-zA-Z1-9]+$#', $karakter_adi))
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Karakter adınız İsim_Soyisim biçiminde olmalıdır.
								</p>
							</div>
							<br><br>
						';
					}
					else if(strlen($karakter_adi) > 21)
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Karakter adınız en fazla 21 karakter olabilir.
								</p>
							</div>
							<br><br>
						';
					}
					else if($user->IsCharacterExists($karakter_adi))
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Karakter adınız başka birisi tarafından kullanılıyor.
								</p>
							</div>
							<br><br>
						';
					}
					else if(!preg_match('/^[a-zA-Z -]+$/', $dogum_yeri))
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Doğum yeriniz sadece harf içerebilir.
								</p>
							</div>
							<br><br>
						';
					}
					else if(strlen($dogum_yeri) > 32)
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Doğum yeri en fazla 32 karakter olabilir.
								</p>
							</div>
							<br><br>
						';
					}
					else if(strlen($hikaye) < 128)
					{
						$hata = '
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Karakter hikayeniz istenilenden daha az şekilde girilmiş.
								</p>
							</div>
							<br><br>
						';
					}
					else
					{
						$user->RegisterPlayerToServer($_SESSION['account_id'], $karakter_adi, $yas, $dogum_yeri, $_SERVER['REQUEST_TIME'], $_SERVER['REMOTE_ADDR']);

						$user->RegisterPlayerToPool($_SESSION['account_id'], $karakter_adi, $hikaye, $arkaplan, $politika, $terim, $_SERVER['REQUEST_TIME']);

						echo '
							<div class="cont">
								<br>
								<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
									<p>
										<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
										Başvurunuz başarıyla gönderildi!
									</p>
								</div>
								<br><br><br><br>
								<center><img src="images/preload.gif"></center>
							</div>
							<meta http-equiv="refresh" content="1;URL=index.php?page=char&action=list">
						';
						exit();
					}

					echo '
						<div class="cont">
							<br><font size="2">
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		<a href="index.php?page=cp">Kontrol Paneli</a>
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
					   			<a href="index.php?page=char&action=info">Karakter</a>
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		Karakter Yarat
						   	</font><br><br>
						   	<font size="5">&raquo; Karakter - Karakter Başvurusu</font><br><br>
						   	<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
									Aşağıdaki test bir yazılım tarafından değil, gerçek kişiler tarafından doğrulanacaktır. Ciddi cevaplar verdiğinizden emin olun. Başvurunuz kabul edildiği zaman sunucumuzda bu karakter ile oynayabilirsiniz. Bol şans!
								</p>
							</div>
							<br><br>
							'.$hata.'
							<form method="post">
								<b>Karakter Adı: (Format: İsim_Soyisim)</b><br>
								<input type="text" name="rpname" class="info_tooltip" title="Bu oyun karakterinizin adı olacaktır." id="rpname" size="50" maxlength="24" value="'.$_POST['rpname'].'" /><br><br><br><br>
									<table width="100%">
										<tr>
											<td width="50%">
												<b>Doğum Yeri: (IC)</b><br>
												<input type="text" name="origin" class="info_tooltip" title="Karakterinizin doğduğu yer olacaktır." id="origin" size="32" maxlength="128" value="'.$_POST['origin'].'" />
											</td>
											<td width="20%">
												<b>Doğum Tarihi: (IC - örn. 1958)</b><br>
												<input type="text" name="age" class="info_tooltip" title="Karakterinizin doğduğu yıl olacaktır." id="age" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)" value="'.$_POST['age'].'" />
											</td>
										</tr>
									</table>
									<br><br>
									<center>
										<b>Karakteriniz hakkında <u>kısa</u> bir özgeçmiş yazın. (en az 2 paragraf olmalıdır).</b>
									</center>
									<textarea name="story" id="story" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['story'].'</textarea>
									<br><br>

									<center>
									<div class="notice">
									<b>Son olarak, çok önemli tavsiye, cevaplarınızı not defterinde veya bir yerde yazın çünkü oturum süreniz dolarsa bundan dolayı cevaplarınızı gönderemezsiniz, bu yüzden cevaplarınızı bir yere yazmak sonrasında yapıştırmak en iyisidir.</b><br>Yine, bir başvuru yaparak sunucu kurallarımızı ikinci kez kabul etmiş olacaksınız, ve kurallardaki değişiklikleri takip etmek sizin işinizdir.
									</div>
									</center>
									<br><br>

									<center>
										<b>SA-MP yada farklı bir oyunda RP deneyiminiz oldu mu? Geçmiş deneyiminiz eğer SA-MP\'da olduysa, bunlar hangi sunucu(lar) ve karakter adlarınız?</b>
									</center>
									<textarea name="background" id="background" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['background'].'</textarea>
									<br><br>

									<center>
										<b>Tecavüz, gasp ve dolandırıcılık politikamız nedir?</b>
									</center>
									<textarea name="policy" id="policy" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['policy'].'</textarea>
									<br><br>

									<center>
										<b>Bazı roleplay terimlerini açıklayın, metagaming ve powergaming gibi ve her biri için en az iki örnek verin.</b>
									</center>
									<textarea name="terms" id="terms" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['terms'].'</textarea>
									<br><br>

								<center>
								<div class="notice">Başvuru gönderildikten sonra, başvurunuzun gözden geçirilebilmesi için oyuna giriş yapmanız GEREKİR. Reddedildikten sonra başvurunuzu tekrar gönderiyorsanız da bunu yapmanız gereklidir. Aksi takdirde, başvurunuz gözden geçirilmeyecek ve oyuna giriş yapmadığınız için reddedilecektir.</div>
								<input type="submit" name="submit_application" class="black_button" value="Yukarıdaki beyanlarımı doğruluyorum, başvurum gönderilsin!" />
								</center>
							</form>
							<br><br>
						</div>
					';
				}
				else
				{
					$stmt = $db->connect()->prepare("SELECT * FROM players WHERE accountid = ? AND AccountStatus = 0");
			   		$stmt->execute([$id]);

			   	if($stmt->rowCount())
			   	{
			   		$hata = "Zaten aktif bir başvurun bulunurken başka bir başvuru gönderemezsin";
			   		echo '			<br>	<br>			'.$hata.'';
			   	}
			   	else
			   	{
					echo '
						<div class="cont">
							<br><font size="2">
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		<a href="index.php?page=cp">Kontrol Paneli</a>
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
					   			<a href="index.php?page=char&action=info">Karakter</a>
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		Karakter Yarat
						   	</font><br><br>
						   	<font size="5">&raquo; Karakter - Karakter Başvurusu</font><br><br>
						   	<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
									Aşağıdaki test bir yazılım tarafından değil, gerçek kişiler tarafından doğrulanacaktır. Ciddi cevaplar verdiğinizden emin olun. Başvurunuz kabul edildiği zaman sunucumuzda bu karakter ile oynayabilirsiniz. Bol şans!
								</p>
							</div>
							<br><br>
							'.$hata.'
							<form method="post">
								<b>Karakter Adı: (Format: İsim_Soyisim)</b><br>
								<input type="text" name="rpname" class="info_tooltip" title="Bu oyun karakterinizin adı olacaktır." id="rpname" size="50" maxlength="24" value="'.$_POST['rpname'].'" /><br><br><br><br>
									<table width="100%">
										<tr>
											<td width="50%">
												<b>Doğum Yeri: (IC)</b><br>
												<input type="text" name="origin" class="info_tooltip" title="Karakterinizin doğduğu yer olacaktır." id="origin" size="32" maxlength="128" value="'.$_POST['origin'].'" />
											</td>
											<td width="20%">
												<b>Doğum Tarihi: (IC - örn. 1958)</b><br>
												<input type="text" name="age" class="info_tooltip" title="Karakterinizin doğduğu yıl olacaktır." id="age" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)" value="'.$_POST['age'].'" />
											</td>
										</tr>
									</table>
									<br><br>
									<center>
										<b>Karakteriniz hakkında <u>kısa</u> bir özgeçmiş yazın. (en az 2 paragraf olmalıdır).</b>
									</center>
									<textarea name="story" id="story" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['story'].'</textarea>
									<br><br>

									<center>
									<div class="notice">
									<b>Son olarak, çok önemli tavsiye, cevaplarınızı not defterinde veya bir yerde yazın çünkü oturum süreniz dolarsa bundan dolayı cevaplarınızı gönderemezsiniz, bu yüzden cevaplarınızı bir yere yazmak sonrasında yapıştırmak en iyisidir.</b><br>Yine, bir başvuru yaparak sunucu kurallarımızı ikinci kez kabul etmiş olacaksınız, ve kurallardaki değişiklikleri takip etmek sizin işinizdir.
									</div>
									</center>
									<br><br>

									<center>
										<b>SA-MP yada farklı bir oyunda RP deneyiminiz oldu mu? Geçmiş deneyiminiz eğer SA-MP\'da olduysa, bunlar hangi sunucu(lar) ve karakter adlarınız?</b>
									</center>
									<textarea name="background" id="background" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['background'].'</textarea>
									<br><br>

									<center>
										<b>Tecavüz, gasp ve dolandırıcılık politikamız nedir?</b>
									</center>
									<textarea name="policy" id="policy" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['policy'].'</textarea>
									<br><br>

									<center>
										<b>Bazı roleplay terimlerini açıklayın, metagaming ve powergaming gibi ve her biri için en az iki örnek verin.</b>
									</center>
									<textarea name="terms" id="terms" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)">'.$_POST['terms'].'</textarea>
									<br><br>

								<center>
								<div class="notice">Başvuru gönderildikten sonra, başvurunuzun gözden geçirilebilmesi için oyuna giriş yapmanız GEREKİR. Reddedildikten sonra başvurunuzu tekrar gönderiyorsanız da bunu yapmanız gereklidir. Aksi takdirde, başvurunuz gözden geçirilmeyecek ve oyuna giriş yapmadığınız için reddedilecektir.</div>
								<input type="submit" name="submit_application" class="black_button" value="Yukarıdaki beyanlarımı doğruluyorum, başvurum gönderilsin!" />
								</center>
							</form>
							<br><br>
						</div>
					';
				}
			}
				break;
			}
		}
	}

?>
