<?php

 ?>

<?php
   if(isset($_SESSION['switch_to'])) {

   $stmt = $db->connect()->prepare("SELECT * FROM players WHERE Name=?");
   $stmt->execute([$_SESSION['switched_char']]);

   $row = $stmt->fetch(PDO::FETCH_ASSOC);
   ?>
   <div class="content">
   <div class="cont">
      <br><br>
      <br><br><font size="5">&raquo; Karakter Profili</font><br><br>
      <br>
      <div class="stats">
         <div class="s-pic"><a href="index.php?page=skin"><img src="https://www.gtaonline.net/modules/skinviewer/skins/<?php echo $row['Skin']; ?>.png" alt="Change Skin" /></a></div>
         <?php if($row['online'] == '0') { ?>
         <div class="s-offline">&bull; Offline</div>
         <?php } ?>
         <?php if($row['online'] == '1') { ?>
         <div class="s-online">&bull; Online</div>
         <?php } ?>
         <br><br>
         <div class="s-title">GENEL BİLGİLER</div>
         <div class="s-info">
            <div id="title">
               PLAYER ID:
               <div id="text"><?php echo $row['id']; ?></div>
            </div>
            <div id="title">
               EMAIL:
               <div id="text">GIZLI</div>
            </div>
            <div id="title">
               LEVEL:
               <div id="text"><?php echo $row['Level']; ?></div>
            </div>
            <div id="title">
               HOURS ON:
               <div id="text"><?php echo $row['Exp']; ?></div>
            </div>
            <div id="title">
               PHONE NUMBER:
               <div id="text"><?php echo $row['PhoneNumber']; ?></div>
            </div>
            <div id="title">
               FIGHTING STYLE:
               <div id="text"><?php echo $row['Fightstyle']; ?></div>
            </div>
            <div id="right">
               <div id="title">
                  USERNAME:
                  <div id="text2"><?php echo strtoupper(str_replace("_", " ", $row['Name'])); ?></div>
               </div>
               <div id="title">
                  ADMIN LEVEL:
                  <div id="text2"><?php echo $row['AdminLevel']; ?></div>
               </div>
               <div id="title">
                  UPGRADES:
                  <div id="text2"><?php echo $row['UpgradePoints']; ?></div>
               </div>
               <div id="title">
                  DONATOR LEVEL:
                  <div id="text2"><?php echo $row['DonatorLevel']; ?></div>
               </div>
               <div id="title">
                  DONATE TIME:
                  <div id="text2"><?php echo $row['DonateTime']; ?></div>
               </div>
               <div id="title">
                  DRIVERS LICENSE:
                  <div id="text2">
                     <?php if($row['DriversLicense'] == '1')
                        {
                        echo "Var";
                        }
                        else {
                        echo "Yok";
                        }
                        ?>
                  </div>
               </div>
            </div>
         </div>
         <br><br>
         <div class="s-title">MONEY STATS</div>
         <div class="s-info">
            <div id="title">
               CASH:
               <div id="text">$<?php echo $row['Money']; ?></div>
            </div>
            <div id="right">
               <div id="title">
                  BANK BALANCE:
                  <div id="text2">$<?php echo $row['Bank']; ?></div>
               </div>
               <div id="title">
                  PAYDAY:
                  <div id="text2">$<?php echo $row['Paycheck']; ?></div>
               </div>
            </div>
         </div>
         <br><br><br><br><br><br>
         <br><br><br>
         <div class="s-title">WEAPONS</div>
         <div class="s-info">
            <div id="title">
               PRIMARY WEAPON:
               <div id="text"><?php echo $row['Weapons0']; ?></div>
            </div>
            <div id="title">
               SECONDARY WEAPON:
               <div id="text"><?php echo $row['Weapons1']; ?></div>
            </div>
            <div id="middle">
               <div id="title">
                  AMMO:
                  <div id="text2"><?php echo $row['WeaponsAmmo0']; ?></div>
               </div>
               <div id="title">
                  AMMO:
                  <div id="text2"><?php echo $row['WeaponsAmmo1']; ?></div>
               </div>
            </div>
         </div>
         <br><br>
         <div class="s-title"><a name="job"></a>OLUŞUM & MESLEK</div>
         <div class="s-info">
            <div id="title">
               OLUŞUM:
               <div id="text">
                  <?php
                     if($row['Faction'] == '-1')
                       $job = "Yok";
                     else if($row['Faction'] == '0')
                      $job = "FACTION0";
                     else if($row['Faction'] == '1')
                      $job = "GOV";
                     else if($row['Faction'] == '2')
                      $job = "FBI";
                     else if($row['Faction'] == '3')
                      $job = "LSPD";
                     else if($row['Faction'] == '4')
                      $job = "LSSD";
                     else if($row['Faction'] == '5')
                      $job = "LSFD"; ?>
                  <?php echo $job; ?>
               </div>
            </div>
            <div id="title">
               RÜTBE:
               <div id="text"><?php echo $row['FactionRank']; ?></div>
            </div>
            <div id="title">
               MESLEK:
               <div id="text">
                  <?php
                     if($row['Job'] == '0')
                     $job = "Yok";
                     else if($row['Job'] == '1')
                                      $job = "Meslek1";
                     else if($row['Job'] == '2')
                                   $job = "Meslek2";
                     else if($row['Job'] == '3')
                                    $job = "Meslek3";
                     else if($row['Job'] == '4')
                                   $job = "Meslek4";
                     else if($row['Job'] == '5')
                                   $job = "Meslek5";	?>
                  <?php echo $job; ?>
               </div>
            </div>
            <div id="title">
               YAN MESLEK:
               <div id="text">
                  <?php
                     if($row['SideJob'] == '0')
                     $job = "Yok";
                     else if($row['SideJob'] == '1')
                                      $job = "YanMeslek1";
                     else if($row['SideJob'] == '2')
                                   $job = "YanMeslek2";
                     else if($row['SideJob'] == '3')
                                    $job = "YanMeslek3";
                     else if($row['SideJob'] == '4')
                                   $job = "YanMeslek4";
                     else if($row['SideJob'] == '5')
                                   $job = "YanMeslek5";	?>
                  <?php echo $job; ?>
               </div>
            </div>
         </div>
         <br><br>
         <br><br>
         <div class="s-title">
            <a name="arecord">
            <?php echo strtoupper(str_replace("_", " ", $row['Name'])); ?> ADINA ADMIN KAYITLARI (BAN, KICK, JAIL)
         </div>
         <br>
         <table class="table_sort tablesorter" border="0" cellpadding="0" cellspacing="1">
            <thead>
               <tr>
                  <th>ADMIN</th>
                  <th>TARIH</th>
                  <th>SEBEP</th>
               </tr>
            </thead>
            <?php
               /*
                ban_regid karakter idsi
                ban_accountid baglı olduğu ucp hesabi
               */

               $char_id = $char->getID($_SESSION['switched_char']);

               $stmt = $db->connect()->prepare("SELECT * FROM bans WHERE ban_regid=?");
               $stmt->execute([$char_id]);

               while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

               ?>
            <tfoot>
               <tr>
                  <th><?php echo $row['admin'] ?></th>
                  <th><?php echo $row['date'] ?></th>
                  <th><?php echo $row['reason'] ?></th>
               </tr>
            </tfoot>
            <?php } ?>
            <tbody></tbody>
         </table>
         <br>
         <table class="table_sort tablesorter" border="0" cellpadding="0" cellspacing="1">
            <thead>
               <tr>
                  <th>ADMIN</th>
                  <th>TARIH</th>
                  <th>SEBEP</th>
                  <th>IP</th>
               </tr>
            </thead>
            <?php //kickleri listele ?>
            <tfoot>
               <tr>
                  <th>Kicked by</th>
                  <th>Date</th>
                  <th>Reason</th>
                  <th>IP</th>
               </tr>
            </tfoot>
            <tbody>
            </tbody>
         </table>
         <br>
         <table class="table_sort tablesorter" border="0" cellpadding="0" cellspacing="1">
            <thead>
               <tr>
                  <th>ADMIN</th>
                  <th>TARIH</th>
                  <th>SEBEP</th>
                  <th>SÜRE</th>
                  <th>IP</th>
               </tr>
            </thead>
            <?php //jailleri listele ?>
            <tfoot>
               <tr>
                  <th>Jailed by</th>
                  <th>Date</th>
                  <th>Reason</th>
                  <th>Time</th>
                  <th>IP</th>
               </tr>
            </tfoot>
            <tbody></tbody>
         </table>
         <br>
         <br><br>
      </div>
   </div>
 </div>
<br><br><br><br>
<?php }
   else {
     header("Location:index.php");
   }?>
