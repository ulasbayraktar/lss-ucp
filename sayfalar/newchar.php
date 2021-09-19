<?php

if(!isset($_SESSION['oturum'])) {
  echo '<meta http-equiv="refresh" content="0;URL=index.php?page=home"/>';
  exit;
}

 ?>

<div class="cont">
   <br><br><font size="5">&raquo; Karakter Başvurusu</font><br><br>
   <div id="_info" class="ui-state-highlight ui-corner-all" style="padding: 0 .7em;">
      <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
         Birazdan dolduracağınız sorular sunucunun yetkilileri tarafından kontrol ediliyor. Verdiğiniz cevapları özenle yazdığınızdan emin olun.
      </p>
   </div>
   <br><br>
   <form method="post">
      <b>Karakter adı: (Format: Ad_Soyad)</b><br>
      <input type="text" name="rpname" class="info_tooltip" title="This will be the name of your game character" id="rpname" size="50" maxlength="24" value="" /><br><br>
      <br><br>
      <table width="100%">
         <tr>
            <td width="50%">
               <b>Köken: (IC)</b><br>
               <input type="text" name="origin" class="info_tooltip" title="The place where your character was born" id="origin" size="32" maxlength="128" value="" />
            </td>
            <td width="30%">
               <b>Cinsiyet: (IC)</b><br>
               <select name="gender" id="gender">
                  <option>Erkek</option>
                  <option>Kadın</option>
               </select>
            </td>
            <td width="20%">
               <b>Doğum Yılı: (IC)</b><br>
               <input type="text" name="age" class="info_tooltip" title="The year when your character was born" id="age" size="4" maxlength="4" onKeyPress="return numbersonly(this, event)" value="" />
            </td>
         </tr>
      </table>
      <br><br>
      <center>
         <b>Karakterin hakkında <u>kısa</u> bir arkaplan hikayesi yaz (en az 2 paragraftan oluşmak zorunda).</b>
      </center>
      <textarea name="story" id="story" rows="10" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)"></textarea>
      <br><br>
      <div class="notice">
         <center>
            <b>Başvurunuzun reddedilmesi durumunda tekrar uğraşmamanız açısından buraya yazacaklarınızı önce bir not defterine yazmanız tavsiye edilir.</b><br>
            <br>
            <a target="_blank" href="https://forum.lss-roleplay.com/viewforum.php?f=3">Başvuruyu göndererek sunucudaki tüm kuralları okumuş ve kabul etmiş sayılırsınız. Lütfen tıklayarak yeni & güncel kurallardan haberdar olmaya çalışın.</a><br>
         </center>
      </div>
      <br><br>
      <center>
         <b>Daha önce herhangi bir SA:Mp Roleplay sunucusunda oynadınız mı? Oynadıysanız hangi sunucular? In-Game karakter isimleriniz?</b>
      </center>
      <textarea name="answer1" id="copy" rows="8" cols="90" oncontextmenu="return false;" onKeyDown="return nocopypaste(event)"></textarea>
      <br><br>
      <center>
         <b>blabla hakkında kurallarımız ve politikalarımız nasıl işliyor? Bildiğiniz kadarıyla yazın:</b>
      </center>
      <textarea name="answer2" id="copy2" oncontextmenu="return false;" rows="8" cols="90" onKeyDown="return nocopypaste(event)"></textarea>
      <br><br>
      <center>
         <b>Birkaç genel roleplay teriminden bahsedin (MG, DM, PG gibi):</b>
      </center>
      <textarea name="answer3" id="copy3" oncontextmenu="return false;" rows="8" cols="90" onKeyDown="return nocopypaste(event)"></textarea>
      <input type="hidden" name="gbucp" value="FALSET">
      <br><br>
      <center>
         <div class="notice">Başvuruyu gönderdikten sonra incelenmesi için sunucuya giriş yapmak zorundasınız. Karakteriniz tam anlamıyla kabul edilmez ve oyuna giriş sağlayamazsınız ancak parmak izi niteliğinde çalışır.</div>
         <input type="submit" name="send_app" class="black_button" value="Kuralları onaylıyor, başvurumu gönderiyorum!" />
      </center>
   </form>
   <br><br>
</div>
