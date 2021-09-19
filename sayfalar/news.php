<?php
	if(!$_GET['id'])
  	{
  		exit(header("Location: index.php?page=home"));
  	}

  	if(!$user->IsValidNewsID($_GET['id']))
  	{
		exit(header("Location: index.php?page=home"));
  	}
?>

<div class="cont"><br>

	<?php
	$stmt = $db->connect()->prepare("SELECT * FROM ucp_news WHERE id = ? LIMIT 1");
  	$stmt->execute([$_GET['id']]);
   	while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
   	{
   		echo '
			<div class="post">
				<div class="post-meta clearfix">
					<h4 class="post-title left">
						<a name="post"></a>'.$rows['title'].'
					</h4>
					<p class="post-info right">
						<span>'.$rows['author'].'</span>
						'.$time->GetFullTime($rows['time']).'
					</p>
				</div>
				<div class="post-box">
					<div class="post-content">
						<div class="post-intro">
							<center>
								<img style="max-width:700px;" src="'.$rows['img'].'" alt="Image" />
							</center>
						</div>
					</div>
					<div class="post-footer clearfix">
						<!-- AddThis Button BEGIN -->
						<div class="addthis_toolbox addthis_default_style ">
							<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
							<a class="addthis_button_tweet"></a>
							<a class="addthis_counter addthis_pill_style"></a>
						</div>
						<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
						<script type="text/javascript" src="https://s7.addthis.com/js/250/addthis_widget.js#username=lsrp"></script>
						<!-- AddThis Button END -->
					</div>
				</div>
			</div>
   		';
	}

	if($_SESSION['is_logged'])
	{
		echo '
			<br><br>
			<div class="commentbox_around">
				<div class="commentbox_head">
					<a name="comments"></a>Yorum Ekle
				</div>
				<div class="commentbox_input">
					<form method="post">
						İsim: <br><input type="text" id="ucp_x" size="40" name="pdummy" value="'.$_SESSION['account_name'].'" disabled><br>
						Konu: *<br><input type="text" id="ucp_y" size="40" name="psubject" /><br>
						Yorum: *<br><textarea rows="4" cols="55" name="limitedtextarea" onKeyDown="limitText(this.form.limitedtextarea,this.form.countdown,250);" onKeyUp="limitText(this.form.limitedtextarea,this.form.countdown,250);"></textarea><br>
						<font size="1">
							<input readonly type="text" name="countdown" size="1" value="250" disabled> karakter hakkınız kaldı.
						</font><br>
						<center><input type="submit" id="button_3" value="Submit my comment!" name="pcomment"></center>
					</form>
				</div>
			</div>
		';
	}

	?>

</div>
