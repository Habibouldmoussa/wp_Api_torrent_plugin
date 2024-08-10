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
  //wp_enqueue_style('flat', 'https://cdnjs.cloudflare.com/ajax/libs/flat-ui/2.3.0/css/flat-ui.min.css');
}
add_action('wp_enqueue_scripts', 'fontawesome');

function get_icon($prov, $cat)
{
  $icon = array(
    "flaticon-hd" => "<i class='fa fa-video-camera'></i>",
    "flaticon-ninja-portrait" => "<i class='fa  fa-user-ninja'></i>",
    "flaticon-apps" => "<i class='fa fa-laptop'></i>",
    "flaticon-old-joystick" => "<i class='fa fa-gamepad'></i>",
    "flaticon-dvd" => "<i class='fa fa-video-camera'></i>",
    "flaticon-h264" => "<i class='fa fa-video-camera'></i>",
    "flaticon-documentary" => "<i class='fa fa-video-camera'></i>",
    "flaticon-mp3" => "<i class='fa fa-music'></i>",
    "flaticon-lossless" => "<i class='fa fa-music'></i>",
    "flaticon-album" => "<i class='fa fa-music'></i>",
    "flaticon-divx" => "<i class='fa fa-video-camera'></i>",
    "flaticon-ebook" => "<i class='fa fa-book'></i>",
    "flaticon-audiobook" => "<i class='fa fa-book'></i>",
    "flaticon-music-video" => "<i class='fa fa-video-camera'></i>",
    "flaticon-wii" => "<i class='fa fa-gamepad'></i>",
    "flaticon-psp" => "<i class='fa fa-gamepad'></i>",
    "flaticon-games" => "<i class='fa fa-gamepad'></i>",
    "flaticon-games" => "<i class='fa fa-gamepad'></i>",
    "flaticon-video-dual-sound" => "<i class='fa fa-video-camera'></i>",
    "flaticon-music-single" => "<i class='fa fa-music'></i>",
    "flaticon-tutorial" => "<i class='fa fa-book'></i>",
    "flaticon-comics" => "<i class='fa fa-book'></i>",
    "flaticon-nds" => "<i class='fa fa-gamepad'></i>",
    "flaticon-svcd" => "<i class='fa fa-video-camera'></i>",
    "flaticon-xbox" => "<i class='fa fa-gamepad'></i>",
    "flaticon-playstation" => "<i class='fa fa-gamepad'></i>",
  );

  if ($cat < 200) {
    $icon_pirate = "<i class='fa fa-music'></i>";
  } else if ($cat < 300) {
    $icon_pirate = "<i class='fa fa-video-camera'></i>";
  } else if ($cat < 400) {
    $icon_pirate = "<i class='fa fa-laptop'></i>";
  } else if ($cat < 500) {
    $icon_pirate = "<i class='fa fa-gamepad'></i>";
  } else if ($cat < 600) {
    $icon_pirate = "<i class='fa fa-video-camera'></i>";
  } else if ($cat < 700) {
    $icon_pirate = "<i class='fa fa-book'></i>";
  };

  switch ($prov) {
    case "Torrent9":
      return "<td><i class='" . $cat . "'></td>";
      break;
    case "1337x":
      return  "<td>" . @$icon[$cat] . "</td>";
      break;
    case "ThePirateBay":
      return  "<td>" . $icon_pirate . "</td>";
      break;
    default:
      return  "<td>" . $cat . "</td>";
  };
}
function fonction_shortcode_resulta_search($param, $content)
{
  include(WP_PLUGIN_DIR . "/api_torrent/includes/BarbarousseApi.php");
  $api = new barbarousseApi("https://barbaroussa.alwaysdata.net/www/api_tor/");
  $cherch = htmlspecialchars(urlencode($_GET['s']));
  $cat = @$_GET['cat'];
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
      echo get_icon($value->provider, $value->category);
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
    } else if (isset($value->link)) {
      echo "<td style='max-width:100px;word-break: break-word;' > <a href='  " . $value->link . "' title='downoload' >DOWNLOAS TORRENT</a></td>";
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
