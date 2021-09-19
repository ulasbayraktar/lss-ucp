<?php

	header('Access-Control-Allow-Origin: *');
	if(!$_SESSION['is_logged'])
	{
		exit(header("Location: index.php?page=home"));
	}

	if(!$_SESSION['player_id'])
	{
		exit(header("Location: index.php?page=char&action=list"));
	}

	if($_GET['select'] == 'skin')
	{
		echo '
		<div class="cont"><br>
			<font size="2">
		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		   		<a href="index.php?page=cp">Kontrol Paneli</a>
		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		   		<a href="index.php?page=profile">Profil</a>
		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
			   		Kıyafet Değiştir
		   	</font>
		   	<br><br>
		   		<font size="5">&raquo; Kıyafet Değiştir</font>
		   	<br><br>


Filters:
	<select id="f_skin_race">
		<option value="-1">Any race</option>
		<option value="1">Caucasian</option><option value="2">African American</option><option value="3">Latino</option><option value="4">Asian</option>	</select>
	<select id="f_skin_gender">
		<option value="-1">Any gender</option>
		<option value="1">Male</option><option value="2">Female</option>	</select>
	<select id="f_skin_weight">
		<option value="-1">Any weight</option>
		<option value="1">Normal</option><option value="2">Overweight</option><option value="3">Muscular</option>	</select>
	<select id="f_skin_category">
		<option value="-1">Any category</option>
		<option value="1">Civilian</option><option value="2">Gang Member</option><option value="3">Country & Old people</option><option value="4">Prostitutes</option><option value="5">Sportsmen</option><option value="6">Specific Professions</option><option value="7">Beach Visitor</option><option value="8">Homeless person</option>	</select>
	<button type="button" id="skin_filter_refresh" onclick=\'RefreshSkinList();\'>Refresh</button>
	<div id="skinlist"></div>
	<div id="skinchange"></div>
	</div>
	';
?>
<script>
	var mySkin = -1;
	function RefreshSkinList(showPage){
		if(showPage == undefined) showPage = 0;
		else if(showPage > 0) showPage--;
		$.post( "https://test.bugraozkan.com.tr/lsrptr", {page: showPage, race: $("#f_skin_race").val(), gender: $("#f_skin_gender").val(), weight: $("#f_skin_weight").val(), category: $("#f_skin_category").val()}, function( data ) {
		}).done( function(){
			$("#skinlist").empty();
		}).success( function( data ){
			var skinDump = data;
			skinDump.skins.forEach(function(data){
				$("#skinlist").append("<img onclick=\"SkinChangePreview(" + data.id + ", '" + data.name + "');\" src=\"https://models.ls-rp.com/skins/thumbnail/" + data.name + ".png\">");
			});

			if(skinDump.matches == 0){
				$("#skinlist").append("No skins match your filters.");
			}else{
				if(skinDump.matches > 36)
				{
					$("#skinlist").append("<br />Pages: ");
					for(var i = 1; i <= Math.ceil(skinDump.matches/36); i++)
					{
						var url = RefreshSkinList(i);
						$("#skinlist").append("<a href=\"#\" onclick="+ url +">" + i + "</a> ");
					}
				}
			}
		});
	}
	function SkinChangePreview(skinid, skinname){
		$("#skinchange").empty();
		$("#skinchange").append("<br><br><img src=\"https://models.ls-rp.com/skins/" + skinname + ".png\"><br /><br>");
		$("<input type='submit' value=\"Use This Skin\">").addClass("black_button skinChangeConfirm").appendTo("#skinchange");
		$("#skinchange").fadeIn();
		mySkin = skinid;
		$("body").animate({scrollTop: $("#skinchange").offset().top}, 1500);
	}
	$(function(){
		$("#skinchange").delegate(".skinChangeConfirm", "click", function(){
			$.post("skinchange.php", {skin: mySkin}, function(data){
			}).done( function(data){
				$("#skinchange").html(
					"<br /><div id=\"_info\" class=\"ui-state-highlight ui-corner-all\" style=\"padding: 0 .7em;\">" +
					"<p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span>" +
					data +
					"</p></div><br />"
				);
			});
		});
		RefreshSkinList();
	});
</script>

<?php
	}
	else
	{
		echo '
		<div class="cont"><br>
			<font size="2">
		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		   		<a href="index.php?page=cp">Kontrol Paneli</a>
		   		<img src="images/blue_arrow.png" width="13" height="13" alt="&raquo;" style="margin: 0px 0px -2px;" />
		   		<a href="index.php?page=profile">Profil</a>
		   	</font>
		   	<br><br>
		   		<font size="5">&raquo; Karakter Yönetimi</font>
		   	<br><br>
				<table>
						<tbody><tr>
							<td>
								<a onfocus="this.blur()" href="?page=gameprofile" class="highlightit"><img src="images/game_profile.png" class="hover_out"></a>
							</td>
							<td>
								<b>Oyun Profilini Görüntüle:</b><br>
								Burada kişisel oyun içi istatistiklerinizi görebilirsiniz
							</td>
							<td>
								<a onfocus="this.blur()" href="?page=players" class="highlightit"><img src="images/profile_players.png" class="hover_out"></a>
							</td>
							<td>
								<b>Aktif Oyuncular:</b><br>
								Burada resmi oyun sunucusundaki aktif oyuncuların bir listesini görebilirsiniz.
							</td>
				<!--			<td>
								<a onfocus="this.blur()" href="?page=profile&select=set" class="highlightit"><img src="images/edit_profile.png" class="hover_out" /></a>
							</td>
							<td>
								<b>Edit Settings:</b><br>
								In here you can do basic changes to your userfile. The changes you can do are described below.
							</td>
				-->		</tr>
						<tr>
							<td>
								<a onfocus="this.blur()" target="_blank" href="https://forum.lss-roleplay.com/viewforum.php?f=49" class="highlightit"><img src="images/profile_bugtracker.png" class="hover_out"></a>
							</td>
							<td>
								<b>Bug bildir:</b><br>
								LSS Platformu üzerinde oluşan hataları bu kısımdan bildirin.
							</td>
							<td>
									<a onfocus="this.blur()" href="#" class="highlightit"><img src="images/profile_factioncenter.png" class="hover_out"></a>
							</td>
							<td>
								<b>Oluşum Merkezi:</b><br>
								Bu sadece oluşum üyeleri için bir menü
							</td>
						</tr>
						<tr>
						</tr>
						<tr>
						</tr>
					</tbody></table>
			<br><br>
		</div>
		';
	}
?>
