<div class="cont">
	<br>
	<font size="2">
		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		<a href="index.php?page=home">Anasayfa</a>
		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		Şifremi Unuttum
	</font>
	<br><br><font size="5">&raquo; Şifremi Unuttum</font><br><br>
<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	if($_GET['key'])
	{
		if($user->getEmailFromHash($_GET['key']))
		{
			$eposta = $user->getEmailFromHash($_GET['key']);
			$kullanici_adi = $user->getNameFromHash($_GET['key']);
			$user->setUserHash($_GET['key']);

			$sifre = $user->generateRandomString(8);
			$sifre_hash = strtoupper(hash('Whirlpool', $sifre));

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

            $mail->setFrom('info@ls-rp.web.tr', 'LSS-RP');
            $mail->addAddress($eposta, $kullanici_adi);

            $mail->isHTML(true);
            $mail->Subject = 'LSS-RP Yeni Şifre';
            $mail->Body    = 'Sayın LSS-RP oyuncusu,<br><br>Şifreniz başarıyla değiştirildi. Yeni şifreyi aşağıda bulabilirsiniz:<br><br>Yeni Şifre: <b>'.$sifre.'</b><br><br>Saygılarımızla,<br>Los Santos Stories Yönetim Ekibi.';

            if($mail->send())
            {
				$user->updateUserPassword($kullanici_adi, $sifre_hash);

				echo '
					<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						E-posta adresinize giriş bilgileriniz hakkında yeni bir e-posta gönderildi.
						</p>
					</div>
					<br>
					<meta http-equiv="refresh" content="5; URL=index.php">
				';
            }
            else
            {
				echo '
					E-posta gönderilirken bir sorun oluştu, başvuru alınamadı.
				';
            }

		}
		else
		{
			echo '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						Anahtarınızın süresi doldu veya geçerli değil. Lütfen tekrar deneyin.
					</p>
				</div>
			';
		}
	}
	else
	{
		echo '
			<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Anahtarınızın süresi doldu veya geçerli değil. Lütfen tekrar deneyin.
				</p>
			</div>
		';
	}

?>
</div>
