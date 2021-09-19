<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if(!isset($_SESSION['is_logged']))
	{
		if($user->GetAllUCPIPBlocks($_SERVER["REMOTE_ADDR"]))
		{
			$blocked_time = $user->GetUCPIPBlock($_SERVER["REMOTE_ADDR"], 'blocked_time');

			if((time() - $blocked_time > 14400))
			{
				$_SESSION['login_attemps'] = 0;
				$user->DeleteUCPIPBlock($_SERVER["REMOTE_ADDR"]);
				header("Location: index.php?page=home");
			}
		    else
			{
				echo '
				<div class="cont">
					<div class="text"><br><br>
						<font size="5">&raquo; Servis Dışı</font><br><br>
						<div class="notice">
							Yanlış bir şekilde yasaklandığınızı düşünüyorsanız, bunu forumdaki "Hatalı Yasaklanmalar" bölümünden bildirmekten çekinmeyin.
						</div>
						<b>Yasaklayan:</b><br>The Machine<br>
						<b>Yasaklama Tarihi:</b><br>'.date('d.m.Y H:i:s', $blocked_time).'<br>
						<b>Sebep:</b><br>Çok sayıda geçersiz giriş denemesi nedeniyle Kontrol Paneli\'nden geçici olarak yasaklandınız (1 saat).<br><br><br>
					</div>
				</div>
				';
				exit();
			}
		}


		// Popup Login
		if(isset($_POST['submit_Login']))
		{
			$username = htmlspecialchars(trim($_POST['username_Login']));
			$password = htmlspecialchars(trim($_POST['password_Login']));
			$hassed_password = strtoupper(hash('Whirlpool', $password));
			if($user->Player_LoginCheck($username, $hassed_password))
			{
				$user->OnAccountConnect($username);
				echo '
	        		<div class="cont">
						<br><br><br><br>
						<center><b><font size="4">Başarıyla giriş yaptınız.<br><br><img src="images/preload.gif"></font></b></center>
					</div>
					<meta http-equiv="refresh" content="2;URL=index.php?page=cp">
				';
				exit();
			}
			else
			{
			 	if ($_SESSION['login_attemps'] >= 4)
			 	{
			 		$user->AddUCPIPBlock($_SERVER["REMOTE_ADDR"], $username, time());
			 		echo '
				 		<div class="cont">
							<br><br><br><br>
							<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
								<p>
									<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
									Çok sayıda geçersiz giriş denemesi nedeniyle Kontrol Paneli\'nden geçici olarak yasaklandınız (1 saat).
								</p>
							</div>
						</div>
						<meta http-equiv="refresh" content="5; URL=index.php?page=home">
					';
					exit();
			    }
			    else
			    {
			    	$_SESSION['login_attemps'] ++;
			    }

				echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Hatalı şifre, '.(5-$_SESSION['login_attemps']).' adet hakkınız kaldı.</center></font></b>
					</div>
					<meta http-equiv="refresh" content="2;URL=index.php">
				';
				exit();
			}
		}

		if(isset($_POST['submit_lostuser'])) // A list of accounts has been sent to your e-mail address.
		{
			$eposta_adresi = htmlspecialchars(trim($_POST['lostuser_email']));
			if(empty($eposta_adresi))
	        {
	        	echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Tüm gerekli alanları doldurunuz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->validateEmail($eposta_adresi))
			{
				echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz e-posta adresi geçersiz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->IsEmailExists($eposta_adresi))
			{
				echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz e-posta adresi geçersiz.</center></font></b>
					</div>
				';
				exit();
			}
			else
			{
				$kullanici_adi = $user->getNameFromEmail($eposta_adresi);
				require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/Exception.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/PHPMailer.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/SMTP.php');

	            $mail = new PHPMailer(true);
	            $mail->SMTPDebug = SMTP::DEBUG_OFF;
	            $mail->Host       = 'mail.ls-rp.web.tr';
	            $mail->SMTPAuth   = true;
	            $mail->Username   = 'info@ls-rp.web.tr';
	            $mail->Password   = 'p)c%12Q;J]Zg';
	            $mail->SMTPSecure = 'ssl';
	            $mail->Port       = 465;

	            $mail->setLanguage('tr', realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/language/');
	            $mail->CharSet = "utf-8";

	            $mail->setFrom('info@ls-rp.web.tr', 'LS-RP Türkiye');
	            $mail->addAddress($eposta_adresi, $kullanici_adi);

	            $mail->isHTML(true);
	            $mail->Subject = 'LSS-RP Kayıp Kullanıcı Adı';
	            $mail->Body    = 'Sayın LSS-RP oyuncusu,<br><br>'.$_SERVER["REMOTE_ADDR"].' IP adresi üzerinden karakter listenizi istediğinizi belirttiniz.<br><br>Bu e-posta adresine kayıtlı hesap(lar): '.$kullanici_adi.'<br><br>Saygılarımızla,<br>Los Santos Stories Yönetim Ekibi.';

	            if($mail->send())
	            {
					echo '
						<div class="cont">
							<br><br><br><br>
							<b><font size="4"><center>E-posta adresinize bağlantılı hesapların listesi gönderildi.</center></font></b>
						</div>

					';
					exit();
	            }
	            else
	            {
					echo '
						<div class="cont">
							<br><br><br><br>
							<b><font size="4"><center>E-posta gönderilirken bir sorun oluştu, bağlantılı hesaplar gönderilemedi.</center></font></b>
						</div>
					';
					exit();
	            }
			}
		}

		if(isset($_POST['submit_lostpass']))
		{
			$kullanici_adi = htmlspecialchars(trim($_POST['lostpass_nick']));
			$eposta_adresi = htmlspecialchars(trim($_POST['lostpass_email']));

	        if(empty($kullanici_adi) || empty($eposta_adresi))
	        {
	        	echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Tüm gerekli alanları doldurunuz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->validateEmail($eposta_adresi))
			{
				echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz e-posta adresi geçersiz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->IsEmailExists($eposta_adresi))
			{
				echo '
	        		<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz e-posta adresi geçersiz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->IsUsernameExists($kullanici_adi))
			{
				echo '
					<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz kullanıcı adı geçersiz.</center></font></b>
					</div>
				';
				exit();
			}
			else if(!$user->IsRelativeAccount($kullanici_adi, $eposta_adresi))
			{
				echo '
					<div class="cont">
						<br><br><br><br>
						<b><font size="4"><center>Girdiğiniz e-posta adresi ile kullanıcı adı eşleşmiyor.</center></font></b>
					</div>
				';
				exit();
			}
			else
			{
				// Your key has either expired or is not valid. Please try again.

				$rand_hash = $user->generateRandomString(32);
				require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/Exception.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/PHPMailer.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/SMTP.php');

	            $mail = new PHPMailer(true);
	            $mail->SMTPDebug = SMTP::DEBUG_OFF;
	            $mail->Host       = 'mail.ls-rp.web.tr';
	            $mail->SMTPAuth   = true;
	            $mail->Username   = 'info@ls-rp.web.tr';
	            $mail->Password   = 'p)c%12Q;J]Zg';
	            $mail->SMTPSecure = 'ssl';
	            $mail->Port       = 465;

	            $mail->setLanguage('tr', realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/language/');
	            $mail->CharSet = "utf-8";

	            $mail->setFrom('info@ls-rp.web.tr', 'LS-RP Türkiye');
	            $mail->addAddress($eposta_adresi, $kullanici_adi);

	            $mail->isHTML(true);
	            $mail->Subject = 'LSS-RP Kayıp Şifre';
	            $mail->Body    = 'Sayın LSS-RP oyuncusu,<br><br>Hesabınızın şifresini değiştirme isteği aldık ('.$kullanici_adi.'). Bu şifre değişikliğini talep ettiyseniz, aşağıdaki bağlantıyı tıklayın. (Bu bağlantı 2 saat geçerlidir, süresi biter.)<br><br><a href="https://lss-roleplay/index.php?page=lostpass&key='.$rand_hash.'">https://lss-roleplay/index.php?page=lostpass&key='.$rand_hash.'</a><br><br>Şifre değişikliği istemediyseniz, bu e-postayı yok sayabilir veya yönetim ekibine bildirebilirsiniz.<br><br>Saygılarımızla,<br>Los Santos Stories Yönetim Ekibi.';

	            if($mail->send())
	            {
	            	$user->lostpassUser($kullanici_adi, $rand_hash);

					echo '
						<div class="cont">
							<br><br><br><br>
							<b><font size="4"><center>E-posta adresinize onay içerikli bir posta gönderildi.</center></font></b>
						</div>

					';
					exit();
	            } // <meta http-equiv="refresh" content="2;URL=index.php">
	            else
	            {
					echo '
						<div class="cont">
							<br><br><br><br>
							<b><font size="4"><center>E-posta gönderilirken bir sorun oluştu, yeni şifre gönderilemedi.</center></font></b>
						</div>
					';
					exit();
	            }
			}
		}

	}
	else
	{
		if(isset($_POST['save_memorable']))
		{
			$yeni_gizli_kelime = htmlspecialchars(trim($_POST['new_mem']));
			$yeni_gizli_kelime_ipucu = htmlspecialchars(trim($_POST['new_hint']));
			$guvenlik_yaniti = htmlspecialchars(trim($_POST['sec_answer']));

			if(empty($yeni_gizli_kelime) || empty($yeni_gizli_kelime_ipucu) || empty($guvenlik_yaniti))
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Tüm gerekli alanları doldurunuz.
						</p>
					</div>
					<br>
				';
			}
			else if($user->GetAccount($_SESSION['account_name'], 'security_word') != $guvenlik_yaniti)
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Girdiğiniz güvenlik yanıtı geçersiz.
						</p>
					</div>
					<br>
				';
			}
			else
			{
				$user->SetAccount($_SESSION['account_id'], 'memorable_word', strtoupper(hash('Whirlpool', $yeni_gizli_kelime)));
				$user->SetAccount($_SESSION['account_id'], 'memorable_hint', $yeni_gizli_kelime_ipucu);

				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Bilgileriniz başarıyla güncellendi, hesabınıza tekrar giriş yapınız.
						</p>
					</div><br>
					<meta http-equiv="refresh" content="1; URL=index.php?page=logout">
				';
			}
		}

		if(isset($_POST['save_password']))
		{
			$eposta_adresi = htmlspecialchars(trim($_POST['user_email']));
			$yeni_sifre = htmlspecialchars(trim($_POST['new_pass']));
			$yeni_sifre_tekrar = htmlspecialchars(trim($_POST['repeat_pass']));
			$guvenlik_yaniti = htmlspecialchars(trim($_POST['sec_answer']));

			if(empty($eposta_adresi) || empty($yeni_sifre) || empty($yeni_sifre_tekrar) || empty($guvenlik_yaniti))
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Tüm gerekli alanları doldurunuz.
						</p>
					</div>
					<br>
				';
			}
			else if($user->GetAccount($_SESSION['account_name'], 'email') != $eposta_adresi && !$user->validateEmail($eposta_adresi))
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Girdiğiniz e-posta adresi geçersiz.
						</p>
					</div>
					<br>
				';
			}
			else if($user->GetAccount($_SESSION['account_name'], 'email') != $eposta_adresi && $user->IsEmailExists($eposta_adresi))
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Girdiğiniz e-posta adresi başka biri tarafından kullanılıyor.
						</p>
					</div>
					<br>
				';
			}
			else if($yeni_sifre != $yeni_sifre_tekrar)
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Girdiğiniz şifreler birbiriyle uyuşmuyor.
						</p>
					</div>
					<br>
				';
			}
			else if($user->GetAccount($_SESSION['account_name'], 'security_word') != $guvenlik_yaniti)
			{
				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Girdiğiniz güvenlik yanıtı geçersiz.
						</p>
					</div>
					<br>
				';
			}
			else
			{
				$user->SetAccount($_SESSION['account_id'], 'email', $eposta_adresi);
				$user->SetAccount($_SESSION['account_id'], 'password', strtoupper(hash('Whirlpool', $yeni_sifre)));

				$hata = '
					<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p>
							<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
							Bilgileriniz başarıyla güncellendi, hesabınıza tekrar giriş yapınız.
						</p>
					</div><br>
					<meta http-equiv="refresh" content="1; URL=index.php?page=logout">
				';
			}
		}

		if(isset($_POST['switch_to']))
		{
			$char_id = htmlspecialchars(trim($_POST['switch_char']));

			if($user->GetPlayer($char_id, 'accountid') != $_SESSION['account_id'])
			{
				exit(header("Location: index.php?page=char&action=list"));
			}
			else
			{
				$user->SetAccount($_SESSION['account_id'], 'active_id', $char_id);
				$_SESSION['player_id'] = $char_id;

				$karakter_adi = $user->GetPlayer($_SESSION['player_id'], 'Name');
				$karakter_adi = str_replace("_", " ", $karakter_adi);
				echo '
	        		<div class="cont">
						<br><br><br><br>

						<b><font size="4"><center>'.$karakter_adi.' karakterine geçiş yapılıyor..</center></font></b>
					</div>
					<meta http-equiv="refresh" content="2;URL=index.php?page=profile">
				';
				exit();
			}
		}

		if($_GET['page'] != 'logout')
		{
			$_SESSION['player_id'] = $user->GetAccount($_SESSION['account_name'], 'active_id');
			if($_SESSION['player_id'] != 0)
			{
				if(!$user->GetPlayer($_SESSION['player_id'], 'AccountStatus'))
				{
					$id = $_SESSION['player_id'];
					$acc_id = $_SESSION['account_id'];
					$name = $user->GetPlayer($id, 'Name');
					echo '
						<div class="cont">
							<br><font size="2">
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		<a href="index.php?page=cp">Kontrol Paneli</a>
						   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
						   		Başvuru Durumu
						   	</font><br><br>
						   	<font size="5">&raquo; Başvuru Durumu</font><br>
						   	<br><br>

						<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
							<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
								Başvurunuz henüz incelenmedi. Önünüzde <b>'.$user->GetPlayerQueue($_SESSION['account_id']).'</b> kişi gözüküyor. Sıra numaranız <b>#'.$id.'</b>, eğer yönetici ile iletişime geçeceksiniz bu numarayı kullanın.
								<br><br><br>
						        <b>
						        <font color="red">BU KARAKTER ADIYLA SUNUCUYA GİRMEDİĞİNİZ TAKDİRDE BAŞVURU İŞLENMEYECEKTİR. (Başvurunuzun işlenebilmesi için bir kez oyuna giriş yapıp şifrenizi doğru bir şekilde girmeniz gerekiyor.)
						        </font>
						        </b>
				        	</p>
						</div>
						<br>
						<div id="accordion">
							<h4><a href="#">Şuanki Başvurunuz</a></h4>
							<div>
								<table width="100%">
									<tr>
										<td width="30%">
											<b>Karakter Adı:</b><br>
											'.$name.'
										</td>
										<td width="30%">
											<b>Doğum Yeri:</b><br>
											'.$user->GetPlayer($id, 'Birthplace').'
										</td>
										<td width="20%">
											<b>Yaş:</b><br>
											'.(2020-$user->GetPlayer($id, 'Birthdate')).'
										</td>
									</tr>
								</table>
								<br>
								<b>Karakter Özgeçmişi:</b>
								<br>
								'.$user->GetPlayerApplication($acc_id, $name, 'story').'
								<br><br>

								<b>SA-MP yada farklı bir oyunda RP deneyiminiz oldu mu? Geçmiş deneyiminiz eğer SA-MP\'da olduysa, bunlar hangi sunucu(lar) ve karakter adlarınız?</b>
								<br>
								'.$user->GetPlayerApplication($acc_id, $name, 'background').'
								<br><br>

								<b>Tecavüz, gasp ve dolandırıcılık politikamız nedir?</b>
								<br>
								'.$user->GetPlayerApplication($acc_id, $name, 'policy').'
								<br><br>

								<b>Bazı roleplay terimlerini açıklayın, metagaming ve powergaming gibi ve her biri için en az iki örnek verin.</b>
								<br>
								'.$user->GetPlayerApplication($acc_id, $name, 'terms').'
								<br><br>
							</div>
						</div>
					';
					exit();
				}
			}
		}
	}

?>
