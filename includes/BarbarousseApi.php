<?php

class barbarousseApi
{
    protected string $apiurl; 
    public function __construct(string $apiurl)
    {
        this->apiurl = $apiurl
    }

    private function callapi($urlvar)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiurl . $urlvar,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
    public function getTorrent($search, $prov = "ThePirateBay", $cat)
    {
        if ((count($prov) === 0) || $prov === NULL) {
            $provs = "ThePirateBay";
        } else if (count($prov) > 1) {
            $provs = "";
            foreach ($prov as $key => $item) {
                if ($key + 1 == count($prov)) {
                    $provs .= $item;
                } else {
                    $provs .= $item . '&prov%5B%5D=';
                }
            }
        } else {
            $provs = $prov[0];
        }
        return $this->callapi('torrents/?cherch=' . $search . '&prov[]=' . $provs . '&cat=' . $cat);
    }
    public function testclass()
    {
        $res = "testclass";
        return $res;
    }
}
