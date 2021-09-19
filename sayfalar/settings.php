<?php

if(!isset($_SESSION['oturum'])) {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
  exit;
}

 ?>

<br><br>
<div class="cont">
   <br><font size="5">&raquo; Hesap Ayarları </font><br><br><br>
   <div class="tab_style ui-tabs ui-widget ui-widget-content ui-corner-all">
      <div id="profile" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
         <br>
         <table width="100%">
            <tbody>
               <tr>
                  <td width="40%">
                     <b>Hesap ID:</b>
                  </td>
                  <td width="80%">
                     #<?php echo $user->getID($_SESSION['isim']); ?>
                  </td>
               </tr>
               <tr>
                  <td width="40%">
                     <b>IP adresi:</b>
                  </td>
                  <td width="80%">
                     <?php echo $_SERVER['REMOTE_ADDR']; ?>
                  </td>
               </tr>
               <tr>
                  <td width="40%">
                     <b>E-mail adresi:</b>
                  </td>
                  <td width="80%">
                     <?php echo $user->getEmail($user->getID($_SESSION['isim'])); ?>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <div id="changepw" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
         <form method="post" autocomplete="off">
            <table width="100%">
               <tbody>
                  <tr>
                     <td width="40%">
                        <b>E-mail adresi:</b>
                     </td>
                     <td width="80%">
                        <input autocomplete="off" type="text" size="32" name="email" value="<?php echo $user->getEmail($user->getID($_SESSION['isim'])); ?>">
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">
                        <b>Yeni şifre:</b>
                     </td>
                     <td width="80%">
                        <input autocomplete="off" type="password" name="new_pass" size="48" value="">
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">
                        <b>Yeni şifreyi tekrarla:</b>
                     </td>
                     <td width="80%">
                        <input autocomplete="off" type="password" name="repeat_pass" size="48" value="">
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">
                     </td>
                     <td width="80%"><br>
                        <b>Yeni ayarlarınızı kaydetmek istiyorsanız güvenli sözcüğü girin:</b><br>
                        <i>(<?php echo $user->getMemorableHint($_SESSION['isim']); ?>)</i>
                     </td>
                  </tr>
                  <br>
                  <tr>
                     <td width="40%">
                        <b>Güvenli sözcük:</b>
                     </td>
                     <td width="80%">
                        <input autocomplete="off" type="text" name="memorable_word" size="48" value="">
                     </td>
                  </tr>
                  <tr>
                     <td width="40%">
                        <input type="submit" name="save_settings" class="black_button ui-button ui-widget ui-state-default ui-corner-all" value="Yeni ayarları kaydet" role="button" aria-disabled="false">
                     </td>
                  </tr>
               </tbody>
            </table>
         </form>
      </div>
   </div>
   <br>
</div>
