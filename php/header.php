<?php
   $user = new Users();
   $db = new dbConn();
   $char = new Chars();
   $time = new Time();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   	<a name="top"></a>
   	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="UTF-8">
		<meta name="distribution" content="global" />
		<meta name="keywords" content="lssrp, lss-rp, lossantosstories, lsrp, ucp, ls-rp, sa:mp, sa-mp, multiplayer, gaming, los, santos, roleplay, user, control, panel, role, play, ucp" />
		<meta name="description" content="Los Santos Stories - User Control Panel" />
		<meta name="copyright" content="&copy; Los Santos Stories 10" />
		<link rel="icon" type="image/vnd.microsoft.icon" href="icon.ico">
		<link rel="stylesheet" type="text/css" href="style.css?v=1" />
      <link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/ui-darkness/jquery-ui.css" rel="stylesheet" />
		<script type="text/javascript" src="UCP_js/ucp_js.js"></script>
		<script type="text/javascript" src="UCP_js/jquery.js"></script>
		<script type="text/javascript" src="UCP_js/jquery-migrate-1.2.1.js"></script>
		<script type="text/javascript" src="UCP_js/jquery.DOMWindow.js"></script>
		<script type="text/javascript" src="UCP_js/jquery.ui.js"></script>
		<title>Los Santos Stories - User Control Panel</title>

      <style type="text/css">
         .ui-state-highlight .ui-state-error {
            padding: 0.7em;
         }

         .cont {
            padding: 0.5em;
         }

      </style>

   	</head>
   	<body>
      <a name="top"></a>
      <div id="page" style="overflow: initial;">
         <div id="header">
            <ul class="social">
               <div id="dlsamp"><a href="https://ls-rp.com/sa-mp-0.3.DL-R1-install.exe">SA-MP 0.3.DL</a></div>
               <div id="discord"><a href="https://discord.gg/uMvdM9azDH">Discord</a></div>
            </ul>
            <a href="index.php?page=home">
               <h1></h1>
            </a>
            <ul class="menu">
               <?php
               if($user->GetAllUCPIPBlocks($_SERVER["REMOTE_ADDR"]))
               {
                  echo '
                     <li class="item"><a href="index.php?page=home" title="Anasayfa">Anasayfa</a></li>
                     <li class="img"></li>
                     <li class="item"><a target="_blank" href="https://forum.lss-roleplay.com">Forum</a></li>
                     <li class="img"></li>
                     <li class="imgC"></li>
                     <li class="itemC"><a></a></li>
                     <li class="imgC"></li>
                     <li class="itemC"><a></a></li>
                     <li class="imgC"></li>
                     <li class="itemC"><a></a></li>
                     <li class="imgC"></li>
                     <li class="itemC"><a></a></li>
                     <li class="imgC"></li>
                     <li class="itemC"><a></a></li>
                  ';
               }
               else
               {
                  if(isset($_SESSION['is_logged']))
                  {
                     if($_SESSION['player_id'] != 0)
                     {
                        echo '
                           <li class="item"><a href="index.php?page=home" title="Anasayfa">Anasayfa</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=cp" title="Kontrol Paneli">Kontrol Paneli</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=profile" title="Profil">Profil</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=players" title="Aktif Oyuncular">Aktif Oyuncular</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=account" title="Ayarlar">Ayarlar</a></li>
                           <li class="img"></li>
                           ';

                      	if($_SESSION['is_admin']) {
                       		echo '<li class="item"><a href="index.php?page=adminarea">Admin Area</a></li>';
                       	} else {
                       		echo '<li class="item"><a target="_blank" href="https://support.lss-roleplay.com">Destek</a></li>';
                       	}

                        echo '
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=logout">Çıkış Yap</a></li>
                        ';
                     }
                     else
                     {
                        echo '
                           <li class="item"><a href="index.php?page=home" title="Anasayfa">Anasayfa</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=char&action=info" title="Karakter Bilgisi">Karakter</a></li>
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=account" title="Ayarlar">Ayarlar</a></li>
                           <li class="img"></li>
                           <li class="item"><a target="_blank" href="https://support.lss-roleplay.com">Destek</a></li>
                           <li class="img"></li>
                           <li class="item"><a target="_blank" href="https://forum.lss-roleplay.com">Forum</a></li>
                           <li class="img"></li>
                        ';

                       	if($_SESSION['is_admin']) {
                       		echo '<li class="item"><a href="index.php?page=adminarea">Admin Area</a></li>';
                       	} else {
                       		echo '<li class="item"><a href="index.php?page=credits">Yapımcılar</a></li>';
                       	}

                       	echo '
                           <li class="img"></li>
                           <li class="item"><a href="index.php?page=logout">Çıkış Yap</a></li>
                        ';
                     }
                  }
                  else
                  {
                     echo '
                        <li class="item"><a href="index.php?page=home" title="Anasayfa">Anasayfa</a></li>
                        <li class="img"></li>
                        <li class="item"><a target="_blank" href="https://forum.lss-roleplay.com">Forum</a></li>
                        <li class="img"></li>
                        <li class="imgC"></li>
                        <li class="itemC"><a></a></li>
                        <li class="imgC"></li>
                        <li class="itemC"><a></a></li>
                        <li class="imgC"></li>
                        <li class="itemC"><a></a></li>
                        <li class="imgC"></li>
                        <li class="itemC"><a></a></li>
                        <li class="imgC"></li>
                        <li class="itemC"><a></a></li>
                     ';
                  }
               }
               ?>
            </ul>
            <img src="images/emenu.png" alt="End of menu" style="left: 1035px; bottom:85px; position: relative;" />
         </div>
         <div id="below">
            <div id="submenu">
               <div class="wel">
               <?php
               if($user->GetAllUCPIPBlocks($_SERVER["REMOTE_ADDR"]))
               {
                  echo '<a href="index.php?page=home" class="button"><span>Ana Sayfa</span></a>';
               }
               else
               {
	                if(isset($_SESSION['is_logged']))
	                {
	                    if($_SESSION['player_id'] != 0)
	                    {

                        $mb_count = $user->GetAllUnreadUCPMsgs($_SESSION['account_id']);

                        switch($_GET['page'])
                        {
                           case '':
                           case 'home':
                           case 'mb':
                           case 'donator':
                           case 'staff':
                           case 'rules':
                           case 'players':
                           case 'cp':
                           case 'news':
                           {
                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '
                                 <a href="index.php?page=donator" class="button"><span>Donator Sayfası</span></a>
                                 <a href="index.php?page=staff" class="button"><span>Yönetici Takımı</span></a>
                                 <a href="index.php?page=rules" class="button"><span>Genel Kurallar</span></a>
                              ';
                              break;
                           }
                           case 'profile':
                           {
                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '
                                 <a href="index.php?page=account" class="button"><span>UCP Ayarları</span></a>
                              ';
                              break;
                           }
                           case 'donator':
                           case 'account':
                           {
                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '
                                 <a href="index.php?page=donator" class="button"><span>Bağışçı Özellikleri</span></a>

                              ';
                              break;
                           }
                          	case 'control':
                           	case 'ucp_applications':
                           	case 'applications':
                           	case 'adminarea':
                           	{
								echo '
								<a href="index.php?page=ucp_applications" class="button"><span>UCP Hesapları</span></a>
								<a href="index.php?page=applications" class="button"><span>Karakter Başvuruları</span></a>
                        <a href="index.php?page=control" class="button"><span>Kontrol</span></a>
                        <a href="index.php?page=add_staff" class="button"><span>Yetkili Ekle</span></a>
								';
								break;
                           	}
                        }
                     }
                     else
                     {
                        $mb_count = $user->GetAllUnreadUCPMsgs($_SESSION['account_id']);

                        switch($_GET['page'])
                        {
                           case 'home':
                           case 'mb':
                           case 'cp':
                           case 'credits':
                           case 'news':
                           {
                              $mb_count = $user->GetAllUnreadUCPMsgs($user->getID($_SESSION['isim']));

                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '<a href="index.php?page=char&action=info" class="button"><span>Karakter</span></a>';
                              break;
                           }
                           case 'char':
                           {
                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '
                                 <a href="index.php?page=char&action=new" class="button"><span>Karakter Oluştur</span></a>
                                 <a href="index.php?page=char&action=list" class="button"><span>Karakter Listesi</span></a>
                              ';
                              break;
                           }
                           case 'account':
                           {
                              if($mb_count > 0) echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu ('.$mb_count.')</span></a>';
                              else echo '<a href="index.php?page=mb" class="button"><span>Gelen Kutusu</span></a>';
                              echo '
                                 <a href="index.php?page=account" class="button"><span>UCP Ayarları</span></a>
                              ';
                              break;
                           }
                           	case 'control':
                           	case 'ucp_applications':
                           	case 'applications':
                           	case 'adminarea':
                           	{
								echo '
								<a href="index.php?page=ucp_applications" class="button"><span>UCP Hesapları</span></a>
								<a href="index.php?page=applications" class="button"><span>Karakter Başvuruları</span></a>
								<a href="index.php?page=control" class="button"><span>Kontrol</span></a>
								';
								break;
                           	}
                        }
                     }
                  }
                  else
                  {
                     switch($_GET['page'])
                     {
                        case '':
                        case 'home':
                        case 'donator':
                        case 'staff':
                        case 'lostpass':
                        case 'rules':
                        case 'news':
                        {
                           echo '
                              <a href="index.php?page=home" class="button"><span>Ana Sayfa</span></a>
                              <a href="index.php?page=register" class="button"><span>Hesap Oluştur</span></a>
                              <a href="#" id="popupLogin" class="button"><span><img src="images/go_friend.gif" width="12" /> Giriş Yap</span></a>
                              <a href="index.php?page=donator" class="button"><span>Donator Sayfası</span></a>
                              <a href="index.php?page=staff" class="button"><span>Yönetici Takımı</span></a>
                              <a href="index.php?page=rules" class="button"><span>Genel Kurallar</span></a>
                           ';
                           break;
                        }
                        case 'register':
                        {
                           switch($_SESSION['register_step'])
                           {
                              default:
                              {
                                 echo '
                                    <a href="?page=home" class="button"><span>Anasayfa</span></a>
                                    <a href="#" class="button"><span>Adım 1 [Quiz]</span></a>
                                 ';
                                 break;
                              }
                              case 2:
                              {
                                 echo '
                                    <a href="?page=home" class="button"><span>Anasayfa</span></a>
                                    <a href="#" class="button"><span><s>Adım 1 [Quiz]</s></span></a>
                                    <a href="#" class="button"><span>Adım 2 [Şartlar]</span></a>
                                 ';
                                 break;
                              }
                              case 3:
                              {
                                 echo '
                                    <a href="?page=home" class="button"><span>Anasayfa</span></a>
                                    <a href="#" class="button"><span><s>Adım 1 [Quiz]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 2 [Şartlar]</s></span></a>
                                    <a href="#" class="button"><span>Adım 3 [Şartlar]</span></a>
                                 ';
                                 break;
                              }
                              case 4:
                              {
                                 echo '
                                    <a href="?page=home" class="button"><span>Anasayfa</span></a>
                                    <a href="#" class="button"><span><s>Adım 1 [Quiz]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 2 [Şartlar]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 3 [Şartlar]</s></span></a>
                                    <a href="#" class="button"><span>Adım 4 [Kullanıcı Adı]</span></a>
                                 ';
                                 break;
                              }
                              case 5:
                              {
                                 echo '
                                    <a href="?page=home" class="button"><span>Anasayfa</span></a>
                                    <a href="#" class="button"><span><s>Adım 1 [Quiz]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 2 [Şartlar]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 3 [Şartlar]</s></span></a>
                                    <a href="#" class="button"><span><s>Adım 4 [Kullanıcı Adı]</s></span></a>
                                    <a href="#" class="button"><span>Adım 5</span></a>
                                 ';
                                 break;
                              }
                           }
                        }
                     }
                  }
               }
               ?>
               </div>
               <div class="messages"></div>
            </div>
         </div>
         <div id="container">
            <div id="content">
               <div class="rmenu">
                  <div class="rbac">
                  <?php
                     if(!$user->GetAllUCPIPBlocks($_SERVER["REMOTE_ADDR"]))
                     {
                        if(!isset($_SESSION['is_logged']))
                        {
                           echo '
                              <div class="rtop">
                                 <div class="rtitle">Hoş geldin <span>Ziyaretçi.</span> (giriş yapmamış)</div>
                              </div>
                              <p>Lütfen <a href="#" class="popupLogin"><font color="white">giriş yap</font></a> veya <a href="?page=register"><font color="white">kayıt ol</font></a></p>
                           ';
                        }
                        else
                        {
                           if($_SESSION['player_id'] != 0)
                           {
                              $karakter_adi = $user->GetPlayer($_SESSION['player_id'], 'Name');
                              $karakter_adi = str_replace("_", " ", $karakter_adi);

                              echo '
                                 <div class="rtop">
                                    <div class="rtitle">Hoş geldin <span>'.$karakter_adi.'.</span></div>
                                 </div>
                                 <p>
                                    <a href="?page=char&action=unset"><img src="images/go_friend.gif" width="12" /> <font color="#FFFFFF">Karakterden Çıkış Yap (Geri)</font></a>
                                 </p>
                              ';
                           }
                           else
                           {
                              echo '
                                 <div class="rtop">
                                    <div class="rtitle">Hoş geldin <span>'.$_SESSION['account_name'].'</span></div>
                                 </div>
                                 <p>
                                    <a href="#" class="signin"><span><font color="white"><img src="images/go_friend.gif" width="12" /> Karakter Değiştir</font></span></a>
                                 </p>
                                 <fieldset id="signin_menu">
                                    <b>Karakter Listesi:</b><br><br>
                                    <form method="post" id="signin">
                                 ';

                                 $varmi = false;
                                 $stmt = $db->connect()->prepare("SELECT id, Name FROM players WHERE AccountID = ?");
                                 $stmt->execute([$_SESSION['account_id']]);
                                 while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
                                 {
                                    echo '
                                       <input type="radio" name="switch_char" id="'.$rows['id'].'" value="'.$rows['id'].'" />
                                       <input type="text" name="username" id="username" size="40" maxlength="40" value="'.$rows['Name'].'" disabled /><br>
                                    ';

                                    $varmi = true;
                                 }

                                if($varmi)
                                {
									echo '
										<input type="submit" name="switch_to" class="black_button" value="Karakteri Seç" onClick=\'return confirm("Bu karaktere geçmek istediğinizden emin misiniz?");\' />
									';
                                }
                                else
                                {
                                	echo 'Hiç karakterin yok.';
                                }
                                echo '
                                    </form>
                                 </fieldset>
                              ';
                           }
                        }
                     }
                  ?>
                     <div class="rlink">
                        <div class="rtitle2">Sunucu Bilgileri</div>
                        <p style="position: relative; top: 5px;">
                           IP: server.lss-roleplay:7777<br>
                        </p>
                        <img src="images/rline.png" alt="" style="position:relative;top:13px;" />
                     </div>
                  </div>
               </div>

               <?php
                  if(!$_SESSION['is_logged'])
                  {
                     echo '
                     <div id="dialog" title="Giriş Yap" style="display: none;">
                        <form method="post" name="login">
                           <label for="username_Login"><b>Kullanıcı Adı:</b></label><br>
                           <input type="text" name="username_Login" id="username_Login" size="32" maxlength="128" /><br><br>
                           <label for="password_Login"><b>Şifre:</b></label><br>
                           <input type="password" name="password_Login" id="password_Login" size="32" maxlength="32" /><br><br>
                           <input type="submit" class="black_button" name="submit_Login" value="Hesabıma Giriş Yap" /><br><br>&raquo; <a href="#" id="popupPassword">Şifreni mi unuttun?</a><br>&raquo; <a href="#" id="popupUserlost">Kullanıcı adını mı unuttun?</a>
                        </form>
                     </div>
                     <div id="lostPass" title="Şifremi Unuttum" style="display: none;">
                        <form method="post" name="lostpass">
                           <label for="lostpass_nick"><b>Kullanıcı Adı:</b></label><br>
                           <input type="text" name="lostpass_nick" id="lostpass_nick" size="32" maxlength="128" /><br><br>
                           <label for="lostpass_email"><b>E-posta Adresi:</b></label><br>
                           <input type="text" name="lostpass_email" id="lostpass_email" size="32" maxlength="128" /><br><br>
                           <font size=2>Bu alan, hesabınızla ilişkili e-posta adresi olmalıdır. Henüz değiştirmediyseniz, hesabınızı kaydettirdiğiniz e-posta adresidir.</font><br><br>
                           <input type="submit" class="black_button" name="submit_lostpass" value="Yeni Şifre Gönder" />
                        </form>
                     </div>
                     <div id="lostUser" title="Kullanıcı Adımı Unuttum" style="display: none;">
                        <form method="post" name="lostuser">
                           <label for="lostuser_email"><b>E-posta Adresi:</b></label><br>
                           <input type="text" name="lostuser_email" id="lostuser_email" size="32" maxlength="128" /><br><br>
                           <font size=2>Bu alan, hesabınızla ilişkili e-posta adresi olmalıdır. Henüz değiştirmediyseniz, hesabınızı kaydettirdiğiniz e-posta adresidir.</font><br><br>
                           <input type="submit" class="black_button" name="submit_lostuser" value="Kullanıcı Adımı Gönder" />
                        </form>
                     </div>
                     ';
                  }

               ?>
