<?php

class VirusTotal extends cvf
{

    protected $apiKey;

    public function set_apiKey(string $apiKey)
    {
        $this->apiKey = $apiKey; #'727a03e23283263096ac07bd6d08eab18cbe865b82c120073113ffe7b19a984c';
    }
    

    public function url($domain)
    {
        //get API KEY from environment, or set your API key here
        $api_key = $this->apiKey;
        $data = array('apikey' => $api_key, 'domain' => $domain);
        $ch = curl_init();
        $url = 'https://www.virustotal.com/vtapi/v2/domain/report?';
        $url .= http_build_query($data); // append query params
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1); // remove this if your not debugging
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // please compress data
        curl_setopt($ch, CURLOPT_USERAGENT, "gzip, Aerro");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($status_code != 200)  return $result;
        
        $js = json_decode($result, true);
        
        curl_close($ch);
        
        return $result;
    }
}