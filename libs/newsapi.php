<?php

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

class Newsapi extends cvf
{

    protected $apiKey;

    protected $targetUrl;

    public function set_apiKey(string $apiKey)
    {
        $this->apiKey = $apiKey; #'21340f15b2174f11b2e13424dc77d17a';
    }


    public function request(string $endpoint = 'top-headlines', array $options)
    {
        $url =  'https://newsapi.org/v2/' . $endpoint . '?';

        foreach ($options as $key => $value) {
            $url = $url . $key . '=' . $value . '&';
        }

        $this->targetUrl = $url . 'apiKey='.$this->apiKey;
        
        return  (object)  json_decode(file_get_contents($this->targetUrl), true);
       
    }
}