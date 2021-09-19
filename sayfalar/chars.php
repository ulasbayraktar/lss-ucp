<?php

if(!isset($_SESSION['oturum'])) {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
  exit;
}

 ?>

<?php
   $stmt = $db->connect()->prepare("SELECT * FROM players WHERE accountid=?");
   $stmt->execute([$user->getID($_SESSION['isim'])]);
   $chars = $stmt->rowCount();
   ?>
<div class="cont">
   <br><br><br><font size="5">» Karakter Listesi</font><br><br>Bu sayfa üzerinde karakterlerinize geçerek onlar hakkında işlem yapabilirsiniz.
   Aktif olarak bu hesaba bağlı <b><?php echo $chars; ?></b> karakteriniz mevcut. (MAX 3)<br><br><br>
   <form method="POST" class="niceform">
     <?php $i = 0; while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
     <input type="radio" name="char_name" value="<?php echo $row['Name']; ?>"><label for="<?php echo $i; ?>">
     <input type="text" name="gereksiz" id="<?php echo $i; ?>" size="40" maxlength="40" value="<?php echo str_replace("_", " ", $row['Name']); ?>" disabled=""></label><br><br>
     <?php $i++; } ?>
     <br>
     <input type="submit" name="switch_to" id="button" value="Seçili karaktere geçiş yap!" class="ui-button ui-widget ui-state-default ui-corner-all" role="button" aria-disabled="false">
   </form>
   <br><br><br><br><br><br>
</div>
