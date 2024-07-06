<?php  
//include_once($_SERVER['DOCUMENT_ROOT'].'dev/wp-load.php'); 

class BerbarousseApi {     
    private $apiurl = "https://api-torrent.barberousse.tk/";

    public function __construct() {      
    }
    
    private function callapi ($urlvar) {
    //private function callapi () {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $this->apiurl.$urlvar,
          //CURLOPT_URL => "https://api-torrent.barberousse.tk/torrents/?cherch=Cyberpunk&prov=ThePirateBay&cat=all",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          //CURLOPT_HTTPHEADER => 'Accept: application/json'
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
       
        //return $reponse = json_decode($response);
        return json_decode($response);
    }
    public function getTorrent($search,$prov,$cat) {        
      if( count($prov) > 1 ) {   
        $provs = "";
            foreach ($prov as $key => $item) {
                //var_dump($key);
                if ( $key+1 == count($prov) ) {
                    //$provs .=$key;
                    $provs .=$item;
                }else{    
                    $provs .=$item.'&prov[]=';
                }
            }   
        } else {
            $provs = $prov ;
        }
      return $this->callapi('torrents/?cherch='.$search.'&prov[]='.$provs.'&cat='.$cat);
        //$this->callapi();
    //return var_dump($provs);

    } 
    public function testclass (){
    //$res = "testclass";
        return $res;

    }

}