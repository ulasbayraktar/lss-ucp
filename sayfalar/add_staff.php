<div class="cont">
  <br><br><br><font size="5">» Yetkili Ekle</font><br><br>

  <?php
    if(!$_SESSION['is_logged'])
      {
        exit(header("Location: index.php?page=home"));
      }

      if(!$_SESSION['is_admin'])
      {
        exit(header("Location: index.php?page=cp"));
      }

      if(isset($_POST['save_general']))
      {
        if(!htmlspecialchars(trim($_POST['name'])))
        {
          echo '<div class="ui-state-error">Yetkili adı girmediniz.</div>';
        }
      
      else if(!htmlspecialchars(trim($_POST['forum'])))
        {
          echo '<div class="ui-state-error">Yetkili forum adresi girmediniz.</div>';
        }

        else if($_POST['permission'] < 0 || $_POST['permission'] > 10)
        {
          echo '<div class="ui-state-error">Geçersiz yetki girdiniz.</div>';  
        }

      else if(!htmlspecialchars(trim($_POST['permission_description'])))
        {
          echo '<div class="ui-state-error">Yetkili görev açıklaması girmediniz.</div>';
        }

        else
        {
          $sql = $db -> connect() -> prepare('INSERT INTO staff SET name = :name, forumlink = :forum, adminlevel = :permission, yetki = :description');
          $sql -> execute([
            'name' => htmlspecialchars($_POST['name']),
            'forum' => htmlspecialchars($_POST['forum']),
            'permission' => $_POST['permission'],
            'description' => $_POST['permission_description']
          ]);

          if($sql)
          {
            echo '<div class="ui-state-highlight">Yetkili listesi güncellendi.</div>';
          }

          else
          {
            echo '<div class="ui-state-error">Yetkili listesi güncellenemedi.</div>';
          }
        }
      }
  ?>

  <div id="general" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
     <form method="post">
        <table width="100%">
           <tbody>
              <tr>
                 <td width="40%">
                    <b>Yetkili adı</b>
                 </td>
                 <td width="80%">
                    <input type="text" name="name">
                 </td>
              </tr>
              <tr>
                 <td width="40%">
                    <b>Forum adresi</b>
                 </td>
                 <td width="80%">
                    <input type="text" name="forum">
                 </td>
              </tr>
              <tr>
                 <td width="40%">
                    <b>Görev</b>
                 </td>
                 <td width="80%">
                    <select name="permission">
                      <option value="10">Management</option>
                      <option value="8">Lead Admin</option>
                      <option value="6">Developer</option>
                      <option value="4">Seviye 4</option>
                      <option value="3">Seviye 3</option>
                      <option value="2">Seviye 2</option>
                      <option value="1">Seviye 1</option>
                      <option value="0" selected="">Tester</option>
                    </select>
                 </td>
              </tr>
              <tr>
                 <td width="40%">
                    <b>Görev açıklaması</b>
                 </td>
                 <td width="80%">
                    <input type="text" name="permission_description">
                 </td>
              </tr>
              <tr>
                 <td width="40%">
                    <input type="submit" name="save_general" class="black_button ui-button ui-widget ui-state-default ui-corner-all" value="Ekle">
                 </td>
              </tr>
           </tbody>
        </table>
     </form>
  </div>

</div>