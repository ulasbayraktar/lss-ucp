<?php
  if(!$_SESSION['is_logged'])
  {
    exit(header("Location: index.php?page=home"));
  }

  if(!$_SESSION['is_admin'])
  {
    exit(header("Location: index.php?page=cp"));
  } 

  echo '<div class="cont"><br>';

  if($_GET['id'])
  {

    $id = $_GET['id'];

    if($_POST['submit_acceptapp'])
    {
        $stmt = $db->connect()->prepare("UPDATE players SET AccountStatus = 1 WHERE id = ?");
        $stmt->execute([$id]);
        $user->AddUCPMsg(0, $user->GetPlayer($id, "accountid"), "Karakter Başvurunuz Onaylandı!", "Karakter başvurunuz onaylandı. Hesap adınız ile karakterinize bağlanabilirsiniz.", $_SERVER['REQUEST_TIME']);
    
        if(!$user->GetPlayer($id, 'id'))
        {
          exit(header("Location: index.php?page=applications"));
        }

        if($user->GetPlayer($id, 'AccountStatus'))
        {
          exit(header("Location: index.php?page=applications"));
        }
    }
    else if($_POST['submit_denyapp'])
    {
        $user->SetAccount($user->GetPlayer($id, "accountid"), 'active_id', 0);

        $user->AddUCPMsg(0, $user->GetPlayer($id, "accountid"), "Karakter Başvurunuz Red Edildi!", "Karakter başvurunuz red edildi. Bilgilerinizi tekrar gözden geçirip deneyebilirsiniz. Sebep: ".$_POST['red_reason']."", $_SERVER['REQUEST_TIME']);
        $stmt = $db->connect()->prepare("DELETE FROM players WHERE id = ?");
        $stmt->execute([$id]);

        if(!$user->GetPlayer($id, 'id'))
        {
          exit(header("Location: index.php?page=applications"));
        }

        if($user->GetPlayer($id, 'AccountStatus'))
        {
          exit(header("Location: index.php?page=applications"));
        }
    }
    else
    {
      if(!$user->GetPlayer($id, 'id'))
      {
        exit(header("Location: index.php?page=applications"));
      }

      if($user->GetPlayer($id, 'AccountStatus'))
      {
        exit(header("Location: index.php?page=applications"));
      }

      $sahtekarlik_orani = 0;
      $status = $user->GetPlayer($id, 'IsLogged') ? "<font color='green'>giriş yapmış</font>" : "<font color='red'>giriş yapmamış</font>";
      $acc_id = $user->GetPlayer($id, 'accountid'); $name = $user->GetPlayer($id, 'Name');
      $hwid = $user->GetPlayer($id, 'HWID');

      $dilimler = $user->GetPlayerApplication($acc_id, $name, 'story');
      $hikaye_orani = $dilimler[0];
      $hikaye_tarihi = $dilimler[4];
      $hikaye_durumu = $user->GetDifferenceStatus($dilimler[3]);
      $hikaye_rengi = $user->GetDifferenceColor($hikaye_orani, $brightness = 200);
      $hikaye_orani_sahibi = $dilimler[1];
      $hikaye_orani_icerigi = $dilimler[2];


      $dilimler = $user->GetPlayerApplication($acc_id, $name, 'background');
      $background_orani = $dilimler[0];
      $background_tarihi = $dilimler[4];
      $background_durumu = $user->GetDifferenceStatus($dilimler[3]);
      $background_rengi = $user->GetDifferenceColor($background_orani, $brightness = 200);
      $background_orani_sahibi = $dilimler[1];
      $background_orani_icerigi = $dilimler[2];

      $dilimler = $user->GetPlayerApplication($acc_id, $name, 'policy');
      $policy_orani = $dilimler[0];
      $policy_tarihi = $dilimler[4];
      $policy_durumu = $user->GetDifferenceStatus($dilimler[3]);
      $policy_rengi = $user->GetDifferenceColor($policy_orani, $brightness = 200);
      $policy_orani_sahibi = $dilimler[1];
      $policy_orani_icerigi = $dilimler[2];

      $dilimler = $user->GetPlayerApplication($acc_id, $name, 'terms');
      $terms_orani = $dilimler[0];
      $terms_tarihi = $dilimler[4];
      $terms_durumu = $user->GetDifferenceStatus($dilimler[3]);
      $terms_rengi = $user->GetDifferenceColor($terms_orani, $brightness = 200);
      $terms_orani_sahibi = $dilimler[1];
      $terms_orani_icerigi = $dilimler[2];

      $sahtekarlik_orani = ($hikaye_orani + $background_orani + $policy_orani + $terms_orani) / 4;

      $stmt = $db->connect()->prepare("SELECT * FROM players WHERE id = ? AND AccountStatus = 0");
      $stmt->execute([$id]); $row = $stmt->fetch(PDO::FETCH_ASSOC);
      }
      echo '
          <div id="accordion">
            <h4><a href="#">Başvuru Detayları #'.$id.'</a></h4>
            <div>
           	<br>
  			<b>İncelediğiniz başvuru '.$row['Name'].' numarası #'.$id.' oyuna '.$status.' ve The Machine kopya oranını <font color="#'.$user->GetDifferenceColor($sahtekarlik_orani, $brightness = 200).'">%'.$sahtekarlik_orani.'</font> olarak eşleştirdi.</b>
             	<br>
              <br>
              <table width="100%">
                <tr>
               	<td width="17%">
                    <b>UCP Adı:</b><br>
                    '.$user->GetAccountFromID($acc_id, 'name').'
                  </td>
                  <td width="20%">
                    <b>Karakter Adı:</b><br>
                    '.$row['Name'].'
                  </td>
                  <td width="20%">
                    <b>Kabul/Red Oranı:</b><br>
                    <font color="green">'.$user->GetAccountFromID($acc_id, 'acceptcount').'</font> / <font color="red">'.$user->GetAccountFromID($acc_id, 'deniedcount').'</font>
                  </td>
                  <td width="12%">
                    <b>Doğum Yeri:</b><br>
                    '.$row['Birthplace'].'
                  </td>
                  <td width="10%">
                    <b>Cinsiyet:</b><br>
                    '.$user->GetGender($row['Gender']).'
                  </td>
                  <td width="5%">
                    <b>Yaş:</b><br>
                    '.(2020-$row['Birthdate']).'
                  </td>
                </tr>             
              </table>
              <br>

              <br>
              <b>Benzer IP adresine sahip hesaplar/karakterler:</b>
              <br>
            ';
              $wut = $db->connect()->prepare("SELECT * FROM players WHERE LastIP = ? AND id != ?");
              $wut->execute([$_SERVER["REMOTE_ADDR"], $id]);

              while($rows = $wut->fetch(PDO::FETCH_ASSOC))
              {
                echo ''.$rows['Name'].' ('.$acc_id.' - IP: '.$rows['LastIP'].') ';
              }

          echo '
              <br><br>

              <b>Benzer HWID adresine sahip hesaplar/karakterler:</b>
              <br>
            '; 
              $wut = $db->connect()->prepare("SELECT * FROM players WHERE HWID = ? AND id != ?");
              $wut->execute([$hwid, $id]);

              while($rows = $wut->fetch(PDO::FETCH_ASSOC))
              {
                echo ''.$rows['Name'].' ('.$acc_id.' - HWID: '.$rows['HWID'].') ';
              }
          echo '
              <br><br>

              <b>Karakter Özgeçmişi:</b>
              <br>
                '.$user->GetPlayerApplication($acc_id, $name, 'story').'
              ';
              if($hikaye_orani > 0)
              {
                echo '
                  <br>
                  <b><font color="#'.$hikaye_rengi.'">The Machine '.$time->GetFullTime($hikaye_tarihi).' tarihinde gönderilen <u>'.$hikaye_durumu.'</u> bir başvuruyla eşleşme sağladı. Benzerlik oranı: %'.$hikaye_orani.' Benzeyen içeriği son gönderen: '.$hikaye_orani_sahibi.'</font></b>
                  <br>
                  <b>Benzeyen içerik:</b> '.$hikaye_orani_icerigi.'
                ';
              }
          echo '  
              <br><br>

              <b>SA-MP yada farklı bir oyunda RP deneyiminiz oldu mu? Geçmiş deneyiminiz eğer SA-MP\'da olduysa, bunlar hangi sunucu(lar) ve karakter adlarınız?</b>
              <br>
                '.$user->GetPlayerApplication($acc_id, $name, 'background').'
              ';
              if($background_orani > 0)
              {
                echo '
                  <br>
                  <b><font color="#'.$background_rengi.'">The Machine '.$time->GetFullTime($background_tarihi).' tarihinde gönderilen <u>'.$background_durumu.'</u> bir başvuruyla eşleşme sağladı. Benzerlik oranı: %'.$background_orani.' Benzeyen içeriği son gönderen: '.$background_orani_sahibi.'</font></b>
                  <br>
                  <b>Benzeyen içerik:</b> '.$background_orani_icerigi.'
                ';
              }
          echo '    
              <br><br>

              <b>Tecavüz, gasp ve dolandırıcılık politikamız nedir?</b>
              <br>
                '.$user->GetPlayerApplication($acc_id, $name, 'policy').'
              ';
              if($policy_orani > 0)
              {
                echo '
                  <br>
                  <b><font color="#'.$policy_rengi.'">The Machine '.$time->GetFullTime($policy_tarihi).' tarihinde gönderilen <u>'.$policy_durumu.'</u> bir başvuruyla eşleşme sağladı. Benzerlik oranı: %'.$policy_orani.' Benzeyen içeriği son gönderen: '.$policy_orani_sahibi.'</font></b>
                  <br>
                  <b>Benzeyen içerik:</b> '.$policy_orani_icerigi.'
                ';
              }
          echo '         
              <br><br>

              <b>Bazı roleplay terimlerini açıklayın, metagaming ve powergaming gibi ve her biri için en az iki örnek verin.</b>
              <br>
              '.$user->GetPlayerApplication($acc_id, $name, 'terms').'
              ';
              if($terms_orani > 0)
              {
                echo '
                  <br>
                  <b><font color="#'.$terms_rengi.'">The Machine '.$time->GetFullTime($terms_tarihi).' tarihinde gönderilen <u>'.$terms_durumu.'</u> bir başvuruyla eşleşme sağladı. Benzerlik oranı: %'.$terms_orani.' Benzeyen içeriği son gönderen: '.$terms_orani_sahibi.'</font></b>
                  <br>
                  <b>Benzeyen içerik:</b> '.$terms_orani_icerigi.'
                ';
              }
          echo ' 
              <br><br>
              <form method="post">
                <a>Eğer red ediyorsanız sebebi:</a>
                <input type="text" name="red_reason"><br>
                <input type="submit" class="black_button" name="submit_denyapp" value="Reddet">
                <input type="submit" class="black_button" name="submit_acceptapp" value="Kabul Et">
              </form>

            </div>
          </div>
          <br><br>
        ';
    }
    else
    {
      echo '
          <div class="s-title">
            <a name="arecord">
            Karakter Başvuruları ('.$user->GetPlayerApplicationCount().' adet başvuru cevaplanmayı bekliyor)
          </div>
          <br>
          <table class="app_table tablesorter" border="0" cellpadding="0" cellspacing="1">
            <thead>
               <tr>
                  <th>TARIH</th>
                  <th>UCP ADI</th>
                  <th>KARAKTER ADI</th>
                  <th>İŞLEMLER</th>
               </tr>
            </thead>
            <tfoot>
        ';
            $stmt = $db->connect()->prepare("SELECT * FROM players WHERE AccountStatus = 0"); 
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
  			$status = $row['IsLogged'] ? "<font color='green'>oyuna giriş yapmış</font>" : "<font color='red'>oyuna giriş yapmamış</font>";

  			$name = $user->GetAccountFromID($row['accountid'], 'name');

  			echo '
  				<tr>
  				<th>28.05.2020 17:30</th>
  				<th>'.$name.'</th>
  				<th>'.$row['Name'].' ('.$status.')</th>
  				<th><a href="index.php?page=applications&id='.$row['id'].'">INCELE</a></th>
  				</tr>
  			';
            }

      echo '</tfoot>
          <tbody></tbody>
        </table>
      ';
    }
    echo '</div>';
  

?>

