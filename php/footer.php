			</div>
			<script>$(document).ready(function() { window.history.replaceState('', '', window.location.href) });</script>
			<div class="bottom">
			   <div class="lbottom">Left side</div>
			   <div class="rbottom">Right side</div>
			</div>
			<div id="footer">
			   Copyright &copy; 2019-2021 Los Santos Stories - design by kavinsky, Greenie & bobster - coding by BlueG, krisk & Mmartin, re-design haroldfinch & Martin
			   All rights reserved.
			</div>
		</div>
	</div>
</body>
</html>
<?php

if(isset($_POST['send_app']))
{
/*

rpname
origin
gender
age
story
answer1 - roleplay geçmişi
answer2 - sunucu politikaları
answer3 - roleplay terimleri
send_app

*/

$name = $_POST['rpname'];
$origin = $_POST['origin'];

if($_POST['gender'] == 'Erkek')
$gender = '1';
else if($_POST['gender'] == 'Kadın')
$gender = '2';

$age = $_POST['age'];
$story = $_POST['story'];

$answer1 = $_POST['answer1'];
$answer2 = $_POST['answer2'];
$answer3 = $_POST['answer3'];

$acc_name = $_SESSION['isim'];

$acc_id = $user->getID($acc_name);

if($char->checkCharExistance($name))
{
echo '<script>alert("Zaten böyle bir karakter kayıtlı.")</script>
<meta http-equiv="refresh" content="1;URL=index.php">';
}
else if($char->hasThreeChars($acc_id))
{
echo '<script>alert("Karakter açma limitini (3) doldurmuşsun.")</script>
<meta http-equiv="refresh" content="1;index.php?page=home">';
}
else
{
$char->sendApp($name, $origin, $gender, $age, $story, $answer1, $answer2, $answer3, $acc_id);

echo '<script>alert("Başarıyla karakter başvurusunu gönderdin. Şimdi onaylanmasını beklemelisin.")</script>
<meta http-equiv="refresh" content="0;index.php?page=chars">';
}


}

else if(isset($_POST['switch_to']))
{
$char_name = $_POST['char_name'];

if(isEmpty($char_name)) {
 echo '<script>alert("Bir karakter seçmemişsin.")</script>';
 echo '<meta http-equiv="refresh" content="0;URL=index.php?page=chars"/>';
}
else {
 $_SESSION['switch_to'] = true;
 $_SESSION['switched_char'] = $char_name;
 echo '<script>alert("Karakterine başarıyla geçtin. Birazdan yönlendirileceksin.")</script>';
 echo '<meta http-equiv="refresh" content="0;URL=index.php?page=mychar"/>';
}
}

else if(isset($_POST['apponayla']))
{
$id = $_POST['id'];

echo '<script>alert("Karakteri kabul ettin.")</script>';

$char->onayla($id);

if(isset($_SESSION['admin']))
{
echo '<meta http-equiv="refresh" content="0;URL=index.php?page=admin"/>';
}

if(isset($_SESSION['tester']))
{
echo '<meta http-equiv="refresh" content="0;URL=index.php?page=tester"/>';
}
}

else if(isset($_POST['appreddet']))
{
$id = $_POST['id'];

echo '<script>alert("Karakteri reddettin.")</script>';

$char->reddet($id);

if(isset($_SESSION['admin']))
{
echo '<meta http-equiv="refresh" content="0;URL=index.php?page=admin"/>';
}

if(isset($_SESSION['tester']))
{
echo '<meta http-equiv="refresh" content="0;URL=index.php?page=tester"/>';
}

}

else if(isset($_POST['save_settings']))
{

$email = $_POST['email'];
$new_pass = strtoupper(hash("Whirlpool", $_POST['new_pass']));
$repeat_pass = strtoupper(hash("Whirlpool", $_POST['repeat_pass']));
$mem_word = strtoupper(hash("Whirlpool", $_POST['memorable_word'])); echo "<br>";
$user_mem_word = $user->getMemorableWord($user->getID($_SESSION['isim']));

if($mem_word != $user_mem_word)
{
echo
'
<script>alert("Güvenli kelimeyi yanlış veya boş girdin.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';
exit;
}

if(!isEmpty($email) && (!isEmpty($new_pass)) && (!isEmpty($repeat_pass)) && (!isEmpty($mem_word)))
{
if($new_pass != $repeat_pass)
echo
'
<script>alert("Yeni şifreniz ile tekrarı uyuşmuyor. Lütfen tekrar deneyin.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';

$stmt = $db->connect()->prepare("UPDATE accounts SET email=?, password=? WHERE id=?");
$stmt->execute([$email, $new_pass, $user->getID($_SESSION['isim'])]);

echo
'
<script>alert("Ayarların güncellendi.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';

}

else if(isEmpty($email) && (!isEmpty($new_pass)) && (!isEmpty($repeat_pass)) && (!isEmpty($mem_word)))
{
if($new_pass != $repeat_pass)
echo
'
<script>alert("Yeni şifreniz ile tekrarı uyuşmuyor. Lütfen tekrar deneyin.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';

$stmt = $db->connect()->prepare("UPDATE accounts SET password=? WHERE id=?");
$stmt->execute([$new_pass, $user->getID($_SESSION['isim'])]);

echo
'
<script>alert("Ayarların güncellendi.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';

}

else if(!isEmpty($email) && (isEmpty($new_pass)) && (isEmpty($repeat_pass)) && (!isEmpty($mem_word)))
{
$stmt = $db->connect()->prepare("UPDATE accounts SET email=? WHERE id=?");
$stmt->execute([$email, $user->getID($_SESSION['isim'])]);

echo
'
<script>alert("Ayarların güncellendi.")</script>
<meta http-equiv="refresh" content="0;URL=index.php?page=settings" />
';

}

}

function isEmpty($string)
{
if(strlen($string) < 1)
return true;
else
return false;
}

?>
