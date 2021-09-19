<div class="cont">

			<br><font size="2"><img src="images/blue_arrow.png" width="13" height="13" alt="»" style="margin: 0px 0px -2px;"> <a href="?page=cp">Control Panel</a> <img src="images/blue_arrow.png" width="13" height="13" alt="»" style="margin: 0px 0px -2px;"> <a href="?page=profile">Profile</a> <img src="images/blue_arrow.png" width="13" height="13" alt="»" style="margin: 0px 0px -2px;"> Spawn location</font><br><br><font size="5">» Spawn location</font><br><br>
<style>
  #aHouse{
     background: #f0f8fe;
     padding: 10px;
     border: 1px dashed #aaa;
     min-height: 100px;
     margin-bottom: 10px;
  }
  .house_title{
     margin-left: 10px;
     padding: 0px;
     display: inline;
     font-size: 1.2em;
  }
  .house_info{
     display: inline-block;
     padding-left: 15px;
  }
  .tenantList{
     margin: 0;
  }
  .tenantListItem{
     display: block;
  }
  #aHouse a{
     color: #996633;
     cursor: pointer;
  }
</style>
<script>
  $("#spawnChangeBut").button();
  function ConfirmTenantEviction(tenant_id, tenant_name, property_id){
     if( confirm("Are you sure you want to evict " + tenant_name + " from your property?") ){
        window.location.href = 'https://ls-rp.com/?page=profile&select=spawn&evict_prop=' + property_id + '&evict_id=' + tenant_id;
     }
  }
</script>
<div id="aHouse">
  <form method="post" action="https://ls-rp.com/?page=profile&amp;select=spawn">
     <input type="submit" class="black_button ui-button ui-widget ui-state-default ui-corner-all" style="float:right;" id="spawnChangeBut" value="Spawn Here" role="button" aria-disabled="false">
     <input type="hidden" name="spawn_type" value="0">
  </form>

  <div style="
        background: url('map.jpg') no-repeat;
        background-position: -4563px -5235px;
        width: 200px;
        height: 100px;
        float:left;
     "></div>
  <h4 class="house_title">Los Santos Airport</h4><br>
  <div class="house_info">
     Default spawn point available for all players.<br>
     <strong>[ ! ] Note: </strong>You'll spawn here if you don't have money in your bank to pay your rent or bills!
  </div>
</div>
<br><br>

      		<center>
<script data-ad-client="ca-pub-2277990400702058" async="" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" data-checked-head="true"></script>
<!-- LS-RP Bottom -->
<ins class="adsbygoogle" style="display: none !important; width: 728px; height: 90px;" data-ad-client="ca-pub-9252748953503585" data-ad-slot="6838217819" data-adsbygoogle-status="done"><!--No ad requested because of display:none on the adsbygoogle tag--></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>

		</center>
		<br><br>
		</div>
