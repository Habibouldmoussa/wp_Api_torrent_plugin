<?php
/*
 * Add my new menu to the Admin Control Panel
 */

// Hook the 'admin_menu' action hook, run the function named 'barbarousse_Add_My_Admin_Link()'
add_action('admin_menu', 'barbarousse_Add_My_Admin_Link');

// Add a new top level menu link to the ACP
function barbarousse_Add_My_Admin_Link()
{
  add_menu_page(
    'Barbarousse admin api', // Title of the page
    'Barbarousse admin api', // Text to show on the menu link
    'manage_options', // Capability requirement to see the link
    'api_torrent/includes/barbarousse-page.php' // The 'slug' - file to display when clicking the link
  );
}
function fontawesome()
{
  wp_enqueue_script('font-awesome', 'https://kit.fontawesome.com/253bfe4b5c.js');
}
add_action('wp_enqueue_scripts', 'fontawesome');

function fonction_shortcode_resulta_search($param, $content)
{
  include(WP_PLUGIN_DIR . "/api_torrent/includes/BarbarousseApi.php");
  $api = new barbarousseApi;
  $cherch = $_GET['s'];
  $cat = $_GET['cat'];
  $prov = $_GET['prov'];
  $res = $api->getTorrent($cherch, $prov, $cat);


  echo "<br> 
  <div class='container'>
    <div class='row'>
    <div class='col-md-12 table-responsive'>

   <table class='table table-striped  table-hover '>
     <tr>
      <th>Titre</th>      
      <th>Catégorie</th>      
      <th>Time</th>      
      <th>Seeds</th>      
      <th>Peers</th>      
      <th>Size</th>      
      <th width='50%'>Download</th>
      <th>Provider</th>
     </tr>";

  foreach ($res as $key => $value) {
    echo "<tr>";
    echo "<td>" . $value->title . "</td>";
    if (isset($value->category)) {
      echo "<td>" . $value->category . "</td>";
    } else {
      echo "<td>Unknown</td>";
    }
    if (isset($value->time)) {
      echo "<td>" . $value->time . "</td>";
    } else {
      echo "<td>0</td>";
    }
    echo "<td>" . $value->seeds . "</td>";
    if (isset($value->peers)) {
      echo "<td>" . $value->peers . "</td>";
    } else {
      echo "<td>0</td>";
    }
    echo "<td>" . $value->size . "</td>";
    if (isset($value->magnet)) {
      echo "<td style='max-width:100px;word-break: break-word;' > <i class='fa-solid fa-magnet'></i> <a href='  " . $value->magnet . "' title='downoload' >DOWNLOAS MAGNET</a> </td>";
    } else {
      echo "<td>N/A</td>";
    }
    echo "<td>" . $value->provider . "</td>";
    echo "</tr>";
  }
  echo  "</table>
  </div>
  </div>
  </div>
  ";
}
add_shortcode('resulta_search', 'fonction_shortcode_resulta_search');
