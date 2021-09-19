<div class="cont">
<div class="wrapper">
   <div id="staffdisclaimer">
      <div id="widecontentWrap">
         <div id="widecontentborders">
            <p>
               <strong>Los Santos Stories Yönetim Ekibi</strong>
               <bar>
                  Herhangi bir yetkilinin ismine tıklayarak profiline ulaşabilirsin.
               </bar>
            </p>
         </div>
         <div id="widecontentBottom"></div>
      </div>
   </div>
   <div class="clear"></div>

   <?php


      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 10');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="management">
               <div id="managementWrap">
                  <div id="widecontentborders">
                     <ul id="list">
                  <?php

                  $sql2 = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 1337');
                  $sql2 -> execute();
                  foreach($sql2 as $row)
                  {
                     if(isset($_SESSION['is_admin']))
                        echo '<li class="bluestaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                     else echo '<li class="bluestaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                  }

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="redstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="redstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="widecontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 8');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="leadadmin">
               <div id="leadadminWrap">
                  <div id="widecontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="redstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="redstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="widecontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 4');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="levelFour">
               <div id="levelFourWrap">
                  <div id="thincontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="thincontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 3');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="levelThree">
               <div id="levelThreeWrap">
                  <div id="thincontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="thincontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 2');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="levelTwo">
               <div id="levelTwoWrap">
                  <div id="thincontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="thincontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 1');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="levelOne">
               <div id="levelOneWrap">
                  <div id="thincontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="greenstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="thincontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 6');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="developers">
               <div id="developersWrap">
                  <div id="widecontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="bluestaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="bluestaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="widecontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }
      

      $sql = $db -> connect() -> prepare('SELECT * FROM staff WHERE adminlevel = 0');
      $sql -> execute();

      if($sql)
      {
         if($sql -> rowCount() > 0)
         {
            ?>

            <div id="testers">
               <div id="testersWrap">
                  <div id="widecontentborders">
                     <ul id="list">
                  <?php

                     foreach($sql as $row)
                     {
                        if(isset($_SESSION['is_admin']))
                           echo '<li class="brownstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span> <a class="fas fa-user-times" href="index.php?page=remove_staff?id=' . $row['id'] . '"></a></li>';

                        else echo '<li class="brownstaff"><a href="'. $row['forumlink'] . '""> ' . $row['name'] . '</a><span class="greystaff"> - ' . $row['yetki'] . '</span></li>';
                     }

                  ?>
                     </ul>
                  </div>
                  <div id="widecontentBottom"></div>
               </div>
            </div>

            <div class="clear"></div>
            <?php
         }
      }

   ?>
   <br>
   </div>
</div>
