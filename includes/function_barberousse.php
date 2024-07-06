<?php
/*
 * Add my new menu to the Admin Control Panel
 */
 
// Hook the 'admin_menu' action hook, run the function named 'barberousse_Add_My_Admin_Link()'
add_action( 'admin_menu', 'barberousse_Add_My_Admin_Link' );
 
// Add a new top level menu link to the ACP
function barberousse_Add_My_Admin_Link()
{
      add_menu_page(
        'Barberousse admin api', // Title of the page
        'Barberousse admin api', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'api_torrent/includes/berbarousse-page.php' // The 'slug' - file to display when clicking the link
    );
}
function fonction_shortcode_resulta_search($param, $content) {
include(WP_PLUGIN_DIR."/api_torrent/includes/BerbarousseApi.php");
    $api = new BerbarousseApi;
    $cherch = $_GET['cherch'];
    $cat = $_GET['cat'];
    $prov = $_GET['prov'];   
    $res = $api->getTorrent($cherch,$prov,$cat);
  
 echo "<div class='container'>
 <div class='row'>
 <div class='col-md-12'>

 <table class='table table-striped table-responsive-md'>
   <tr>
    <th>Titre</th>      
    <th>Catégorie</th>      
    <th>Time</th>      
    <th>Seeds</th>      
    <th>Peers</th>      
    <th>Size</th>      
    <th>Download</th>
    <th>Provider</th>

   </tr>";  
   
    foreach ($res as $key => $value){    
    echo "<tr>";    
      echo "<td>".$value->title."</td>";
      echo "<td>".$value->category."</td>";
      echo "<td>".$value->time."</td>";
      echo "<td>".$value->seeds."</td>";
      echo "<td>".$value->peers."</td>";
      echo "<td>".$value->size."</td>";     
      echo "<td>".$value->magnet."</td>";
      echo "<td>".$value->provider."</td>";
    echo "</tr>";  
    }    //$res = var_dump($prov);
    //return ;
    
echo  "</table>
</div>
</div>
"; 
 }
 add_shortcode('resulta_search', 'fonction_shortcode_resulta_search');
 