<?php
	if(!$_SESSION['is_logged'])
  	{
    	exit(header("Location: index.php?page=home"));
  	}

  	if(!$_SESSION['is_admin'])
  	{
    	exit(header("Location: index.php?page=cp"));
  	}

	class CountryISPDB extends SQLite3
	{
		function __construct()
		{
			$this->open('class/geoip/geoip.db');
		}
	}

	class CityDB extends SQLite3
	{
		function __construct()
		{
			$this->open('class/geoip/geoip_city.db');
		}
	}

	function IPtoLong($ip)
	{
		$ips = explode(".", $ip);
		$tmp = ((16777216 * $ips[0]) + (65536 * $ips[1]) + (256 * $ips[2]) + $ips[3]);
		return $tmp;
	}
?>
<div class="cont">
	<br>
	<b>Lütfen bir IP adresi girin</b><br />
	<form name="track_form" method="post">
		<input name="ip" type="text" id="ip" maxlength="24"/><br />
		<input type="submit" name="submit_ipcontrol" value="IP İzle" style="width: 128px"/>
	</form>

	<?php
	if(isset($_POST['submit_ipcontrol']))
	{
		$ip_adresi = htmlspecialchars(trim($_POST['ip']));


		if(!preg_match("/^([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})(\.([1]?\d{1,2}|2[0-4]{1}\d{1}|25[0-5]{1})){3}$/", $ip_adresi))
		{
			echo sprintf("IP adresi %s geçersiz, lütfen tekrar deneyin.", $ip_adresi);
		}
		else 
		{
			$url = file_get_contents("http://ip-api.com/json/$ip_adresi?fields=country,countryCode");
			$decode = json_decode($url, true);
			echo "<b>$ip_adresi adresinin whois bilgileri aşağıdadır:</b>";
			echo '<div style="margin-top: 5px; overflow:auto; height:250px; width:560px">';
			echo '<table>';
			echo '<tbody>';
			echo '<tr><td width="50">Ülke</td><td width="50">'.$decode['country'].'('.$decode['countryCode'].') <img src="images/flags/'.strtolower($decode['countryCode']).'.png"></td></tr>';
			echo '<tr><td width="50">ISP</td><td width="350">'.$decode['isp'].'</td></tr>';
			echo '<tr><td width="50">Şehir</td><td width="50">'.$decode['regionName'].' '.$decode['city'].' '.$decode['zip'].'</td></tr>';
			echo '<tr><td width="50">Enlem</td><td width="50">'.$decode['lat'].'</td></tr>';
			echo '<tr><td width="50">Boylam</td><td width="50">'.$decode['lon'].'</td></tr>';
			echo '<tr><td width="50">Mobil</td><td width="50">'.($decode['mobile'] ? "Evet" : "Hayır").'</td></tr>';
			echo '<tr><td width="50">Proxy</td><td width="50">'.($decode['proxy'] ? "Evet" : "Hayır").'</td></tr>';
			echo '</tbody></table></div>';
			echo "<br>";
		}
	}

	
					
	


	?>
  	<br><br>
</div>	