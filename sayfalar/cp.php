<?php 
	if(!isset($_SESSION['is_logged']))
	{
		exit(header("Location: index.php?page=home"));
	}
?>

<div class="cont">
   	<br>
   	<font size="2">
   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
   		<a href="index.php?page=cp">Kontrol Paneli</a> 
   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" /> 
   		Anasayfa
   </font>
   <br>
   <br><br>
   <div id="pinboard" style="position:relative;">
   	<?php
   		$i = 0;
   		$colors = array("yellow", "purple", "blue", "orange", "green", "dblue", "blue2", "dblue2");
		$stmt = $db->connect()->prepare("SELECT * FROM ucp_news ORDER BY title DESC LIMIT 10");
		$stmt->execute();
		while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '
	      		<div class="'.$colors[$i].' basic_tooltip" title="'.$rows['author'].' tarafından '.$rows['created_at'].' tarihinde paylaşıldı.">
	      			<a href="?page=news&id=624">'.$rows['title'].'</a>
	      		</div>
			';

			$i++;
		}

   	?>
   </div>
   <br><br>
   <b><u>Genel Bilgilendirme</u></b><br>
   Kullanıcı Kontrol Panelinde, hem kendi karakteriniz hem de sunucu hakkında faydalı bilgiler de dahil olmak üzere çok çeşitli yararlı işlevler bulabilirsiniz. Karakterinizi düzenlemek, profilinize bakmak, spawn konumunuzu yada skin değiştirmek, arkadaşlarınızın sunucudaki durumuna bakmak, hataları bildirmek gibi şeyler, bu kullanışlı panel ile yapabileceklerinizin sadece küçük bir kısmıdır! Bağışçılar oynanışı geliştirecek çeşitli avantajlar da bulabilirler!
   <br><br>
</div>