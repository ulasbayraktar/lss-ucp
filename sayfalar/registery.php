<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	if($_SESSION['is_logged'])
	{
		exit(header("Location: index.php?page=cp"));
	}

	if(isset($_GET['del']))
	{
		if($_GET['del'] != $_SESSION['rand_string'])
		{
			exit(header("Location: index.php?page=register"));
		}

		foreach ($_SESSION as $key => $val)
		{
			if(strpos($key, 'post-answer-') !== false) $_SESSION[''.$key.''] = false;
		}
		echo '<meta http-equiv="refresh" content="1;URL=index.php?page=register"/>';
		$_SESSION['already_submitted'] = 0;
		$_SESSION['register_step'] = 0;
	}

	// Kayıt adım 1
	if(isset($_POST['submit_Quiz']))
	{
		if ($_POST['token'] != $_SESSION['token'])
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p>
						<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						Token değeri geçersiz.
					</p>
				</div>
				<br><br><br>
			';
		}
		else
		{
			if($_SESSION['already_submitted'] != 2)
			{
				$d = 0; $toplam = 10;
				foreach ($_SESSION as $key => $val)
				{
					if(strpos($key, 'post-answer-') !== false)
					{
						if($_SESSION[''.$key.''] == true)
						{
							$result = explode("-", $key);
							if($_POST[$key] == $user->cevapKontrol($result[2])) $d++;
						}
					}
					$_SESSION[''.$key.''] = false;
				}

				if($d != 10)
				{
					$toplam = $toplam - $d;
					$hata = '
						<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
						Üzgünüm, cevaplarının <b>'.$toplam.'</b> tanesi yanlış, <b>'.$d.'</b> tanesi doğru. Kayıt olmaya devam etmek için hepsini doğru girmelisin.</p>
						</div>
						<br><br><br>
					';
				}
				else
				{
					$hata = '
						<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
							<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
							Tebrikler, quizi başarıyla geçtin. Lütfen bekleyin...</p>
						</div>
						<br><br><br>
						<meta http-equiv="refresh" content="5">
					';
					$_SESSION['already_submitted'] = 2;
					$next_step++;
				}
			}
		}

		$_SESSION['token'] = rand(100000, 999999);
   	}

   	// Kayıt adım 2
	if(isset($_POST['submit_Quiz2']))
	{
		if($_SESSION['register_step'] < 2)
		{
			exit(header("Location: index.php?page=register"));
		}

		if($_POST['terms'] != 'kabul ediyorum')
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kayıt işlemine devam etmek için aşağıdaki forma "kabul ediyorum" yazmalısınız. Kullanım koşullarını kabul etmiyorsanız, kayıt işlemini iptal edin.
					</p>
				</div>
				<br><br><br>
			';
		}
		else
		{
			if($_SESSION['already_submitted'] != 3)
			{
				$hata = '
					<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Tebrikler, şartlarımızı kabul ettin. Lütfen bekleyin...</p>
					</div>
					<br><br><br>
					<meta http-equiv="refresh" content="5">
				';
				$_SESSION['already_submitted'] = 3;
				$next_step++;
			}
		}
	}

	// Kayıt adım 3
	if(isset($_POST['submit_Quiz3']))
	{
		if($_SESSION['register_step'] < 3)
		{
			exit(header("Location: index.php?page=register"));
		}

		if($_POST['terms'] != 'evet, kabul ediyorum')
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kayıt işlemine devam etmek için aşağıdaki forma "evet, kabul ediyorum" yazmalısınız. Kullanım koşullarını kabul etmiyorsanız, kayıt işlemini iptal edin.
					</p>
				</div>
				<br><br><br>
			';
		}
		else
		{
			if($_SESSION['already_submitted'] != 4)
			{
				$hata = '
					<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Tebrikler, SA-MP şartlarını kabul ettin. Lütfen bekleyin...</p>
					</div>
					<br><br><br>
					<meta http-equiv="refresh" content="5">
				';
				$_SESSION['already_submitted'] = 4;
				$next_step++;
			}
		}
   	}

   	// Kayıt 4. adım
   	if(isset($_POST['submit_regname']))
   	{
		if($_SESSION['register_step'] < 4)
		{
			exit(header("Location: index.php?page=register"));
		}

   		$username = htmlspecialchars(trim($_POST['uname']));

   		if (strlen($username) < 4)
   		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kullanıcı adınız 4 karakterden az olamaz.
					</p>
				</div>
				<br><br><br>
			';
        }
        else if (strlen($username) > 20)
        {
        	$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kullanıcı adınız 20 karakterden fazla olamaz.
					</p>
				</div>
				<br><br><br>
			';
        }
        else if (preg_match('/\s/', $username))
        {
        	$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kullanıcı adınız boşluk içeremez.
					</p>
				</div>
				<br><br><br>
			';
        }
        else if (preg_match('/[^A-Za-z0-9]+/', $username))
        {
		    $hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Kullanıcı adınızda Türkçe karakter ve illegal karakterler bulunamaz.
					</p>
				</div>
				<br><br><br>
			';
		}
		else if($user->IsUsernameExists($username))
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Maalesef, bu kullanıcı adı zaten kayıtlı.
					</p>
				</div>
				<br><br><br>
			';
		}
		else
		{
			if($_SESSION['already_submitted'] != 5)
			{
				$hata = '
					<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
						<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
						Tebrikler, '.$username.' son adıma yönlendiriliyorsun. Lütfen bekleyin...</p>
					</div>
					<br><br><br>
					<meta http-equiv="refresh" content="5">
				';
				$_SESSION['register_username'] = $username;
				$_SESSION['already_submitted'] = 5;
				$next_step++;
			}
		}
   	}

   	// Kayıt son adım
   	if(isset($_POST['submit_registration']))
   	{
		if($_SESSION['register_step'] < 5)
		{
			exit(header('Location: index.php'));
		}

        $eposta = htmlspecialchars(trim($_POST['email']));
        $eposta_tekrar = htmlspecialchars(trim($_POST['remail'])); // preg_match("~@gmail\.com$~",$email)

        $guvenlik_sorusu = htmlspecialchars(trim($_POST['sec_question']));
        $guvenlik_yaniti = htmlspecialchars(trim($_POST['sec_answer']));

        $gizli_kelime = htmlspecialchars(trim($_POST['mem_word']));
        $gizli_kelime_ipucu = htmlspecialchars(trim($_POST['mem_hint']));
        $kayit_tarihi = $_SERVER['REQUEST_TIME'];
        $ip_adresi = $_SERVER["REMOTE_ADDR"];

        if(empty($eposta) || empty($eposta_tekrar) || empty($guvenlik_sorusu) || empty($guvenlik_yaniti) || empty($gizli_kelime) || empty($gizli_kelime_ipucu))
        {
        	$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Lütfen tüm gerekli alanları doldurunuz.
					</p>
				</div>
				<br>
			';
		}
		else if($eposta != $eposta_tekrar)
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Girdiğiniz e-posta adresleri eşit değil.
					</p>
				</div>
				<br>
			';
		}
		else if(!$user->validateEmail($eposta))
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Sadece <b>@gmail.com/@hotmail.com/@yahoo.com/@outlook.com</b> uzantısına sahip e-posta adreslerini kabul ediyoruz.
					</p>
				</div>
				<br>
			';
		}
		else if($user->IsEmailExists($eposta))
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Maalesef, bu e-posta adresi zaten kayıtlı.
					</p>
				</div>
				<br>
			';
		}
		else if($gizli_kelime == $gizli_kelime_ipucu)
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Gizli kelime ile ipucusu aynı olamaz.
					</p>
				</div>
				<br>
			';
		}
		else if (preg_match('/[^A-Za-z0-9]+/', $gizli_kelime))
        {
		    $hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Gizli kelimenizde Türkçe karakter ve illegal karakterler bulunamaz.
					</p>
				</div>
				<br>
			';
		}
		else if($user->IsUsernameExists($kadi))
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Maalesef, sizinle aynı anda kayıt olan biri sizden önce bu ismi almış, kayıt işlemine en baştan başlamalısın.
					</p>
				</div>
				<br>
			';
		}
		else if($user->IsIPExists($ip_adresi))
		{
			$hata = '
				<div id="_alert" class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
					<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
					Maalesef, bu IP adresiyle daha fazla hesap oluşturamazsın.
					</p>
				</div>
				<br>
			';
		}
		else
		{
			if($_SESSION['already_submitted'] != 6)
			{
				$sifre = $_POST['password'];
				$sifre_has = strtoupper(hash('Whirlpool', $sifre));
				$gizli_kelime_has = strtoupper(hash('Whirlpool', $gizli_kelime));
				$kullanici_adi = $_SESSION['register_username'];

				require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/Exception.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/PHPMailer.php');
	            require_once(realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/SMTP.php');

	            $mail = new PHPMailer(true);
	            $mail->SMTPDebug = SMTP::DEBUG_OFF;
	            $mail->Host       = 'ucp@lss-roleplay.com';
	            $mail->SMTPAuth   = true;
	            $mail->Username   = 'ucp@lss-roleplay.com';
	            $mail->Password   = 'gC(;{Ltcu4Gu';
	            $mail->SMTPSecure = 'ssl';
	            $mail->Port       = 465;

	            $mail->setLanguage('tr', realpath($_SERVER["DOCUMENT_ROOT"]) .'/ucp/sayfalar/mailer/src/language/');
	            $mail->CharSet = "utf-8";

	            $mail->setFrom('ucp@lss-roleplay.com', 'LSS Roleplay ');
	            $mail->addAddress($eposta, $kullanici_adi);

	            $mail->isHTML(true);

	            $mail->Subject = 'LSS Hesap Bilgileri';
	            $mail->Body    = '<b>LSS\'e Hoşgeldin!</b><br><br>Los Santos Stories\'de aşağıdaki bilgileri içeren bir hesabı başarıyla kaydettiniz.<br><br><b>Kullanıcı Adı:</b> '.$kullanici_adi.'<br><b>Şifre:</b> '.$sifre.'<br><br>Artık hesap bilgilerinizle Kontrol Panelimize giriş yapabilirsiniz. (<a href="https://lss-roleplay.com">lss-roleplay</a>)<br><br>Saygılarımızla,<br>Los Santos Stories Yönetim Ekibi.';

					$user->registerUser($kullanici_adi, $sifre_has, $guvenlik_sorusu, $guvenlik_yaniti, $gizli_kelime_has, $gizli_kelime_ipucu, $eposta, $kayit_tarihi, $ip_adresi);

					$to_id = $user->getID($kullanici_adi);
					$user->AddUCPMsg(0, $to_id, 'Hoşgeldin', 'LSS-RP\'ye hoşgeldin, <b>'.$kullanici_adi.'</b>!<br><br>Bu sizin karakterlerinizi yönetmek için kullanacağınız ana hesabınızdır. Sunucuda oynamanız için sadece ana hesabınız yetmez, bu yüzden <a href="index.php?page=char&action=new" target="_blank">karakter oluşturmak</a> zorundasınız. Karakter başvurunuz yönetim ekibi tarafından kabul edilirse oyun sunucumuzda (role)play yapmaya başlayabilir ve karakterinizi UCP üzerinden yönetebilirsiniz.<br><br>Bu UCP (Kullanıcı Kontrol Paneli) sizin spawn noktanızı, kıyafetinizi ve daha fazlasını değiştirmenizi sağlar. Bol şans diliyoruz!<br><br>Eğer bir sorunuz olursa, forum yada destek sitemizi kullanın.<br><br>Saygılarımızla,<br>Los Santos Stories', $kayit_tarihi);

					$hata = '
						<div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
							<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
							Tebrikler, kayıt başarılı oldu. Giriş yapabilirsiniz.
							</p>
						</div>
						<br>
						<meta http-equiv="refresh" content="15; URL=index.php">
					';

					$_SESSION['already_submitted'] = 6;
					$next_step++;
			}
		}
   	}
?>

<div class="cont">
   <br><br><font size="5">&raquo; Los Santos Stories — Hesap Oluşturma Sayfası </font><br><br>

<?php
	$_SESSION['rand_string'] = $user->generateRandomString(32);
	$rand_string = $_SESSION['rand_string'];

	switch($_SESSION['register_step'])
   	{
   		default:
		{
			$_SESSION['token'] = rand(100000, 999999);
			$token = $_SESSION['token'];

			if($next_step > 0) {
				$_SESSION['register_step'] = 2;
				$next_step = 0;
			}

			foreach ($_SESSION as $key => $val)
			{
				if(strpos($key, 'post-answer-') !== false) $_SESSION[''.$key.''] = false;
			}
	        echo '
	        	<script>$(function() { $(".progressB").progressbar({ value: 20 }); });</script>
	            <center>
	               <br>
	               <h4>ADIM <i>1</i>/<b>5</b>!</h4>
	               <div class="progressB"></div>
	            </center>

	            <br>
	            '.$hata.'


	            <center>
	               <div class="notice">
	                  <b>Şu anda LSS platformu üzerinde bir "hesap" oluşturmak üzeresin. Bu hesabı oluşturduktan sonra yine buradan maksimum üç olmak şartıyla kendine oyun içi karakter oluşturabilirsin. Tek yapman gereken aşağıdaki sorulara doğru yanıtları vererek diğer adımlara ilerlemen. Bol şans!<br />
	                  <br />Dikkat! Bu testi başarıyla tamamlaman sonucunda yalnızca hesabın oluşur. Daha sonra hesabın üzerinden yeni bir karakter başvurusu göndererek incelenmesini beklemelisin.
	                  <br /><br>
	                  &bull; Tüm soruları cevaplayabilmek için, <a target="_blank" href="https://forum.lss-roleplay.com/viewforum.php?f=3"><img src="images/go_friend.gif" width="12"> sunucu kuralları</a> konusunu okumak zorunda kalacaksın.</b>
	               </div>
	            </center>

	            <br>
	            <div style="font-family: Calibri;">
	           		<form method="post">
	         	';

					$stmt = $db->connect()->prepare("SELECT * FROM questions ORDER BY rand() LIMIT 0, 10"); $stmt->execute();
					while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
					{
						$_SESSION['post-answer-'.$rows['id'].''] = true;

						$options = array(
							array("id" => 1, "option" => $rows['answer_1']),
							array("id" => 2, "option" => $rows['answer_2']),
							array("id" => 3, "option" => $rows['answer_3'])
						);

						shuffle($options);

						echo '<b><font size="3">'.$rows['question'].'</font></b><br>';
						foreach($options as $option)
						{
							echo '<input type="radio" onfocus="this.blur()" value="'.$option['id'].'" name="post-answer-'.$rows['id'].'">'.$option['option'].'<br>';
						}
						echo '<br>';
					}
	      	echo '
	                  	<br><br>
	                  	<input type="hidden" name="token" value="'.$token.'">
                  		<center><input type="submit" class="black_button" name="submit_Quiz" value="Cevapları onayla."></center>
	               	</form>
	            </div>
	         	';
        	break;
      	}
      	case 2:
		{
			if($next_step > 0) {
				$_SESSION['register_step'] = 3;
				$next_step = 0;
			}

        	echo '
				<script>$(function() { $(".progressB").progressbar({ value: 40 }); });</script>
				<center>
					<br>
					<h4>ADIM <i>2</i>/<b>5</b>!</h4>
					<div class="progressB"></div>
				</center>
				<br>
				'.$hata.'
				<table with="80%" align="center">
					<tr>
						<td width="100%">
						<b>Kullanım şartları</b>, bu hizmetler herhangi bir ücret ödemenize gerek kalmadan size ücretsiz sunulur, bu nedenle bu ücretsiz hizmetlere erişiminizi istediğiniz zaman kesme hakkımızı saklı tutarız. Hizmetler ücretsiz olduğundan, çalışma süresi ve bu hizmetlerin ne kadar süre açık tutulacağının garantisi yoktur, ayrıca bu hizmetleri herhangi bir zamanda kapatma hakkımızı saklı tutarız.

						<br><br>Ayrıca kişisel IP adresiniz, kullanım tarihiniz ve sunucumuzdaki eylemleriniz de dahil olmak üzere hizmetlerimizin <i>herhangi bir kullanımını</i> <b>günlüğe kaydetme hakkımızı saklı tutarız.</b>

						<br><br>Ayrıca topluluğumuzu ve sunucularımızı canlı tutmak için ödeme yapabilirsiniz ve bunun için son derece müteşekkiriz, ancak bu sizi yukarıdaki şartların üzerinde tutmaz. Bununla birlikte, hizmetlerimizin bakımına diğer oyunculardan daha fazla katkıda bulunanlara karşı daha yumuşak olacağız.

						<br><br>Karakter istismarı, ırkçılık, cinsel içerik vb. temalar ile <b>oyun içinde</b> karşılaşabileceğinizi lütfen unutmayın. Bunlar tamamen oyun içerisinde karşınıza gelebilir ve bu durumları koruyan kurallar vardır. Bu durumlar Karakter Dışı olarak yanlış kullanılırsa ceza alabilirsiniz.

						Bu şartları, <a href="https://forum.lss-roleplay.com/viewforum.php?f=4">sunucu ve forum kurallarını</a> kabul ediyorsanız - aşağıdaki kutuya "<b>kabul ediyorum</b>" yazın. (tırnak olmadan)
						</td>
					</tr>
				</table>
				<form method="POST" class="niceform">
					<table width="80%" align="center">
						<tr>
						<td width="50%"><input type="text" size="20" name="terms" id="terms"></td>
						<td width="50%"><button type="submit" id="button" name="submit_Quiz2" value="Kabul ediyorum!">Kabul ediyorum!</button></td>
						</tr>
					</table>
				</form>
		        <br><br>
		        <a href="?page=register&del='.$rand_string.'"><p align="left"><font size=3>Kayıtı Sıfırla</font></p></a>
		        <br><br>
			';
        	break;
     	}
     	case 3:
      	{
			if($next_step > 0) {
				$_SESSION['register_step'] = 4;
				$next_step = 0;
			}

	        echo '
		        <script>$(function() { $(".progressB").progressbar({ value: 60 }); });</script>
		        <center>
		           <br>
		           <h4>ADIM <i>3</i>/<b>5</b>!</h4>
		           <div class="progressB"></div>
		        </center>
		        <br>
		        '.$hata.'
				<div class="lightblue">
					<b><a href="http://sa-mp.com" target="_blank">SA-MP</a> lisansından alıntı:</b><br>
					------------------------------------------------------------------<br>
					The SA:MP modification for Grand Theft Auto: San Andreas (r) is a<br>
					software research project aimed at extending the functionality of <br>
					the Grand Theft Auto: San Andreas (r) software for Microsoft<br>
					Windows (r).<br>
					------------------------------------------------------------------<br>
					<br>
					The software contained herein is provided on an "as-is" basis without<br>
					any form of warranty.<br>
					<br>
					This software may not be exploited for personal, financial or <br>
					commercial gain.<br>
					<br>
					The author(s) of this software accept no liability for use/misuse of the<br>
					software.<br>
					<br>
					The SA:MP software package may not be distributed, sold, rented or<br>
					leased without written permission of the software author(s).<br>
					<br>
					You may not create or distribute derivative works of the software or files<br>
					contained within the package.<br>
					<br>
					You may not use this software for any illegal purposes.<br>
					<br>
					The author(s) of this software retain the right to modify this license<br>
					at any time.<br>
					<br>
					-------------------------------------------------------------------<br>
					(c) 2005-2010 SA:MP software research team.<br>
					<br>
					SA:MP software research team is not affiliated with Rockstar Games,<br>
					Rockstar North or Take-Two Interactive Software Inc.<br>
					<br>
					Grand Theft Auto and Grand Theft Auto: San Andreas are registered<br>
					trademarks of Take-Two Interactive Software Inc.<br>
					-------------------------------------------------------------------<br>
					<br>
				</div>
				Lisans sözleşmesini kabul ediyorsanız aşağıdaki kutuya "<b>evet, kabul ediyorum</b>" yazın.
		        <form method="POST" class="niceform">
		           <table width="80%" align="center">
		              <tr>
		                 <td width="50%"><input type="text" size="20" name="terms" id="terms"></td>
		                 <td width="50%"><button type="submit" id="button" name="submit_Quiz3" value="SA-MP lisans şartlarını kabul ediyorum!">SA-MP lisans şartlarını kabul ediyorum!</button></td>
		              </tr>
		           </table>
		        </form>
		        <br><br>
		        <a href="?page=register&del='.$rand_string.'"><p align="left"><font size=3>Kayıtı Sıfırla</font></p></a>
		        <br><br>
	        ';
        	break;
      	}
      	case 4:
      	{
			if($next_step > 0) {
				$_SESSION['register_step'] = 5;
				$next_step = 0;
			}

      		echo '
      			<script>$(function() { $(".progressB").progressbar({ value: 80 }); });</script>
		        <center>
		           <br>
		           <h4>ADIM <i>4</i>/<b>5</b>!</h4>
		           <div class="progressB"></div>
		        </center>
		        <br>
		        '.$hata.'
		        <b>Hangi kullanıcı adını kullanmak istersiniz?</b>
		        <br>
		        <br>
		        <form method="POST" class="niceform">
					<input type="text" size="20" name="uname" id="uname">
					<input type="submit" class="black_button ui-button ui-widget ui-state-default ui-corner-all" name="submit_regname" value="Kayıt işlemine devam et." role="button" aria-disabled="false">
				</form>
				<br><br>
		        <a href="?page=register&del='.$rand_string.'"><p align="left"><font size=3>Kayıtı Sıfırla</font></p></a>
		        <br><br>
      		';
      		break;
      	}
      	case 5:
      	{
			if($next_step > 0) {
				$_SESSION['register_step'] = 0;
				$next_step = 0;
			}

      		echo '
      			<script>$(function() { $(".progressB").progressbar({ value: 100 }); });</script>

		        <center>
		           <br>
		           <h4>ADIM <i>5</i>/<b>5</b>!</h4>
		           <div class="progressB"></div>
		        </center>
		        <br>
		        '.$hata.'
		        <b>Not:</b> <b>Geçerli</b> bir e-posta adresi girmelisiniz, aksi halde hesap detaylarını alamayacaksın.
		        <br>
		        <br>
		        <form method="post">
				<table width="100%">
					<tr>
						<td width="25%">
							<b>Kullanıcı Adı:</b>
						</td>
						<td width="75%">
							<input type="text" size="40" name="rpname" id="rpname" value="'.$_SESSION['register_username'].'" disabled>
						</td>
					</tr>
					<tr>
						<td width="25%">
							<b>Şifre:</b>
						</td>
						<td width="75%">
							<input type="password" size="40" name="password" id="password">
						</td>
					</tr>
					<tr>
						<td width="25%">
							<b>E-posta Adresi:</b>
						</td>
						<td width="75%">
							<input type="text" size="40" name="email" id="email">
						</td>
					</tr>
					<tr>
						<td width="25%">
                        <br /><br /><br /><br />
							<b>E-posta Adresi Tekrarı:</b>
						</td>
						<td width="75%">
						(Hesabınızı doğrulayabilmek için geçerli bir e-posta adresi girmeniz <b>GEREKİR</b>. Bu ayrıca, kaybolan şifreleri almak ve desteğe ihtiyaç duymanız durumunda hesabınızın sahipliğini doğrulamak için de kullanılacaktır. E-postalarımızın güvenli bir şekilde teslim edilmesini garanti etmek için, sadece güvenilir<b> @gmail.com/@hotmail.com/@yahoo.com/@outlook</b> e-posta barındırıcılarını kabul ediyoruz.)<br />
							<input type="text" size="40" name="remail" id="remail">
						</td>
					</tr>
					<tr>
						<td width="25%"><br><br><br>
							<b>Güvenlik Sorusu:</b>
						</td>
						<td width="75%"><br><br><br>
							<select name="sec_question" id="sec_question">
								<option value="Çocukluk takma adınız nedir?">Çocukluk takma adınız nedir?</option>
								<option value="En sevdiğiniz çocukluk arkadaşınızın adı nedir?">En sevdiğiniz çocukluk arkadaşınızın adı nedir?</option>
								<option value="İlk öpüştüğünüz erkek ya da kızın adı nedir?">İlk öpüştüğünüz erkek ya da kızın adı nedir?</option>
								<option value="Büyükannenizin kızlık soyadı nedir?">Büyükannenizin kızlık soyadı nedir?</option>
								<option value="İlk işe hangi şehirde veya kasabada girdin?">İlk işe hangi şehirde veya kasabada girdin?</option>
								<option value="15 Temmuz\'u ilk duyduğunuzda neredeydiniz?">15 Temmuz\'u ilk duyduğunuzda neredeydiniz?</option>
								<option value="İlk evcil hayvanınızın adı nedir?">İlk evcil hayvanınızın adı nedir?</option>
								<option value="İlk aşkının adı ne?">İlk aşkının adı ne?</option>
								<option value="Kimlik numaranızın son 5 hanesi nedir?">Kimlik numaranızın son 5 hanesi nedir?</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="25%" valign="top">
							<b>Güvenlik Yanıtı:</b>
						</td>
						<td width="75%">
							<input type="text" size="40" name="sec_answer" id="sec_answer"><br>
                            (<b><font color="red">Hesaplarınızdaki veya karakterlerinizdeki ayarları değiştirirken güvenlik yanıtınız gerekecektir. Lütfen bunu güvende tutun, sıfırlanamaz ve hiçbir personel tarafından görülemez. Unutmamak için kendinize özgü tek bir yanıtı olabilecek bir soru seçin.<br><br>Güvenlik yanıtınızı kaybetmeniz hesaplarınıza ve karakterlerinize erişiminizi kaybetmenize neden olur. Personel bu erişimi sizin için geri getiremez.</font></b>)
						</td>
					</tr>
                    <tr>
						<td width="25%"><br /><br /><br />
							<b>Gizli Kelime:</b>
						</td>
						<td width="75%"><br /><br /><br />
							<input type="text" size="40" name="mem_word" id="mem_word">
						</td>
					</tr>
                    <tr>
						<td width="25%" valign="top">
							<b>Gizli Kelime İpucusu:</b>
						</td>
						<td width="75%">
							<input type="text" size="40" name="mem_hint" id="mem_hint"><br />
                            (<font color="red">Gizli bir kelime ve size bu kelimeyi hatırlatacak bir ipucu girin. Bu gizli kelime ve ipucu personel tarafından görülebilir ve personelden destek almanız gerekiyorsa bu hesabın sahibi olduğunuzu kanıtlarken sizden istenmesi istenir. Unutulmaz kelimeniz ve ipucunuz aynı olamaz ve istendiğinde kolayca sağlayabileceğiniz bir şey olmalıdır. Örneğin, bir evcil hayvan adı, akraba adı, masanızda / odanızda belirli bir öğenin markası / modeli vb.</font>)
						</td>
					</tr>
				</table><br>

				Kaydı Tamamla\'ya tıklayarak, yukarıdaki uyarıları okuduğunuzu ve yukarıdaki ayrıntılardan herhangi birini hatırlamamanın hesaplarınıza erişim kaybıyla sonuçlanacağını anlarsınız. İstendiğinde, yukarıda tamamladığınız bilgileri sağlamazsanız, çalışanlar bilgilerinizin alınmasında veya hesaplarınıza erişim konusunda size yardımcı olamayacaktır.<br />
				<input type="submit" class="black_button" name="submit_registration" value="Kaydı Tamamla!"><br />
			</form>
				<br><br>
		        <a href="?page=register&del='.$rand_string.'"><p align="left"><font size=3>Kayıtı Sıfırla</font></p></a>
		        <br><br>
      		';
      	}

   	}
?>

   <br><br>
</div>
