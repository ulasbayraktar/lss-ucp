<?php

if(!isset($_SESSION['switch_to'])) {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
  exit;
}

 ?>

<br><br><br><div class="wrapper"><div class="cont">

<?php

if($_GET['id']) {
  $char->updateChar('Skin', $_GET['id'], $char->getID($_SESSION['switched_char']));
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=mychar"/>';
  exit;
}
else { ?>
  <?php for($i = 1; $i < 310; $i++) { ?>
    <a href="index.php?page=skin&id=<?php echo $i; ?>"><img style="max-height: 100px; max-width: 50px;" src="https://www.gtaonline.net/modules/skinviewer/skins/<?php echo $i; ?>.png" alt="skin change"></a>
  <?php } ?>
<?php } ?>

<br></div></div>
