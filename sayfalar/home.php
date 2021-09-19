<div class="cont">
   <link rel="stylesheet" type="text/css" href="css/coin-slider-styles.css" rel="stylesheet" />
   <script type="text/javascript" src="UCP_js/coin-slider.min.js"></script><br><br>
   <div id="coin-slider">
      <img src="../ucp/images/slide/slide_a.png" alt="Hey" />
      <span>
      <b>Los Santos Stories</b><br>
      Her gün yeni başvurular ve neredeyse hatasız oyun modu ile etraftaki en kaliteli SA-MP sunucularından biriyiz!
    </span>
      <img src="../ucp/images/slide/slide_b.png" alt="Hey" />
      <img src="../ucp/images/slide/slide_focotdm.png" alt="Hey" />
      <img src="../ucp/images/slide/slide_c.png" alt="Hey" />
      <img src="../ucp/images/slide/slide_d.png" alt="Hey" />
      <img src="../ucp/images/slide/slide_e.png" alt="Hey" />
      <img src="../ucp/images/slide/slide_f.png" alt="Hey" />
   </div>
   <script type="text/javascript">
      $(document).ready(function() {

       $("#coin-slider").coinslider({ spw: 5, sph: 3, width: 750, height: 150, delay: 5000, titleSpeed: 1500, opacity: 0.7, links: false, effect: 'rain' });

      });
   </script>
<br><br><br>
<?php
   $results_per_page = 3;
   if($_GET["s"]) { $page = $_GET["s"]; } else { $page = 1; }
   $start_from = ($page-1) * $results_per_page;

   $stmt = $db->connect()->prepare("SELECT * FROM ucp_news LIMIT ?, ?");
   $stmt->execute([$start_from, $results_per_page]);
   while($rows = $stmt->fetch(PDO::FETCH_ASSOC))
   {
      echo '
         <div class="post">
            <div class="post-meta clearfix">
               <h4 class="post-title left">
                  <a href="index.php?page=news&id='.$rows['id'].'#post">'.$rows['title'].'</a>
               </h4>
               <p class="post-info right">
                  <span>'.$rows['author'].'</span>
                  '.$rows['time'].'
               </p>
            </div>
            <div class="post-box">
               <div class="post-content">
                  <div class="post-intro">
                    	<center><img style="max-width:700px;" src="'.$rows['img'].'" alt="Image" /></center><br />
                  </div>
               </div>
               <div class="post-footer clearfix">
                  <div class="continue-reading">
                     <a href="index.php?page=news&id='.$rows['id'].'#comments">'.$user->GetNewsCommentCount($rows['id']).' Yorum</a>
                  </div>
               </div>
            </div>
         </div>
      <br>
      ';
   }

   echo '<center>';
   $total_pages = ceil($user->GetNewsCount() / $results_per_page);
      echo "<a href='?s=1'>[İlk Sayfa]</a> ";
      echo "<a href='?s=".($_GET["s"]-1)."'>[Önceki Sayfa]</a> ";

      for($i = 1; $i <= $total_pages; ++$i)
      {
         if($i == $page)
         {
            $next_page = $i;
            echo $i." ";
         }
         else
         {
            echo "<a href='?s=".$i."'>".$i."</a> ";
         }
      }

      echo "<a href='?s=".($_GET["s"]+1)."'>[Sonraki Sayfa]</a> ";
      echo "<a href='?s=".$total_pages."'>[Son Sayfa]</a> ";

   echo '
      </center>
   </div>';
?>
