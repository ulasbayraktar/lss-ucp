<div class="cont">

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
      if(!isset($_POST['admin']))
      {
        echo '<div class="ui-state-error">Yetkili bulunamadı.</div>';
      }

      else
      {
        $sql = $db -> connect() -> prepare('DELETE FROM staff WHERE id = :id');
        $sql -> execute([
          'id' => $_POST['id']
        ]);

        if($sql)
        {
          echo '<div class="ui-state-highlight ui-corner-all">Yönetici kaldırıldı.</div>';
        }
      }
    }
?>

  <h4>&raquo; Yetkili Kaldır</h4>

  <div id="general" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
     <form method="post">
        <table width="100%">
           <tbody>
              <tr>
                 <td width="40%">
                    <b>Yetkili adı</b>
                 </td>
                 <td width="80%">
                    <?php

                      $sql = $db -> connect() -> prepare('SELECT * FROM staff');
                      $sql -> execute();

                      if($sql)
                      {
                        if($sql -> rowCount() > 0)
                        {
                          ?>
                            
                            <select name="admin">
                              <?php

                                foreach($sql as $row)
                                {
                                  echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }

                              ?>
                            </select>

                          <?php
                        }
                      }

                    ?>
                 </td>
              </tr>
              <tr>
                 <td width="40%">
                    <input type="submit" name="save_general" class="black_button ui-button ui-widget ui-state-default ui-corner-all" value="Kaldır">
                 </td>
              </tr>
           </tbody>
        </table>
     </form>
  </div>

</div>