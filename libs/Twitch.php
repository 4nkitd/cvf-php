<?php

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class Twitch extends cvf
{
    
    protected $token;

    
    protected $clientId;

    
    protected $client;

   
    protected $scopes;

    public function __construct($token = null, $clientId = null)
    {
        $this->scopes = [
            // 'channel_check_subscription',
            // 'channel_commercial',
            // 'channel_editor',
            // 'channel_feed_edit',
            // 'channel_feed_read',
            // 'channel_read',
            // 'channel_stream',
            // 'channel_subscriptions',
            // 'chat_login',
            // 'collections_edit',
            // 'communities_edit',
            // 'communities_moderate',
            // 'openid',
            // 'user_blocks_edit',
            // 'user_blocks_read',
            // 'user_follows_edit',
            'user_read',
            // 'user_subscriptions',
            // 'viewing_activity_read'
        ];

        // Set token if given
        if ($token) {
            $this->setToken($token);
        }

        // Set clientId if given else get from config
        if ($clientId) {
            $this->setClientId($clientId);
        } elseif ($this->env('twitch-api.client_id')) {
            $this->setClientId($this->env('twitch-api.client_id'));
        } 

        // GuzzleHttp Client with default parameters.
        $this->client = new Client([
            'base_uri' => 'https://api.twitch.tv/kraken/',
            'headers'  => array('Accept' => 'application/vnd.twitchtv.v5+json')
        ]);
    }

    
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    
    public function getClientId($clientId = null)
    {

        // Return given parameter
        if ($clientId) {
            return $clientId;
        }

        // If clientId is null and no clientId has previously been set
        if (!$this->clientId) {
            throw new RequestRequiresClientIdException();
        }

        // Return clientId that has previously been set
        return $this->clientId;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken($token = null)
    {

        // If given parameter is not null, return this parameter
        if ($token) {
            return $token;
        }

        // If token is null and no token has previously been set
        if (!$this->token) {
            throw new RequestRequiresAuthenticationException();
        }

        // Return token that has previously been set
        return $this->token;
    }

    public function sendRequest($type = 'GET', $path = '', $token = false, $options = [], $availableOptions = [])
    {

        // URL parameters
        //$path = $this->generateUrl($path, $token, $options, $availableOptions);
        $path = $this->generateUrl($path, $token, $options, $availableOptions);

        // Headers
        $data = [
          'headers' => [
            'Client-ID' => $this->getClientId(),
            'Accept' => 'application/vnd.twitchtv.v5+json',
          ],
        ];

        // Twitch token
        if ($token) {
            $data['headers']['Authorization'] = 'OAuth '.$this->getToken($token);
        }

        try{
            // Request object
            $request = new Request($type, $path, $data);
            // Send request
            $response = $this->client->send($request);

            // Return body in JSON data
            return json_decode($response->getBody(), true);
        }
        catch(RequestException $e){
            if ($e->hasResponse()) {
                $exception = (string) $e->getResponse()->getBody();
                $exception = json_decode($exception);
                return $exception;
            } else {
                //503
                return array(
                    'error' => 'Service Unavailable',
                    'status' => 503,
                    'message' => $e->getMessage()
                );
            }
        }
        
    }

    public function generateUrl($url, $token, $options, $availableOptions)
    {

        // Append client id
        $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?').'client_id='.$this->getClientId();

        // Append token if provided
        if ($token) {
            $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?').'oauth_token='.$this->getToken($token);
        }

        // Add options to the URL
        foreach ($options as $key => $value) {
            $url .= (parse_url($url, PHP_URL_QUERY) ? '&' : '?').$key.'='.$value;
        }

        return $url;
    }

    public function getAuthenticationUrl($state = null, $forceVerify = false)
    {
        return 'https://api.twitch.tv/kraken/oauth2/authorize?response_type=code'
        .'&client_id='.$this->env('twitch-api.client_id')
        .'&redirect_uri='.$this->env('twitch-api.redirect_url')
        .'&scope='.implode($this->scopes, '+')
        .'&state='.$state
        .'&force_verify='.($forceVerify ? 'true' : 'false');
    }

    public function getAccessObject($code, $state = null)
    {
        $availableOptions = ['client_secret', 'grant_type', 'state', 'code', 'redirect_uri'];

        $options = [
            'client_secret' => $this->env('twitch-api.client_secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'state' => $state,
            'redirect_uri' => $this->env('twitch-api.redirect_url'),
        ];

        return $this->sendRequest('POST', 'oauth2/token', false, $options, $availableOptions);
    }

    public function chat($channel)
    {
        return $this->sendRequest('GET', 'chat/'.$channel);
    }

    public function chatBadges($channel)
    {
        return $this->sendRequest('GET', 'chat/'.$channel.'/badges');
    }

    public function chatEmoticons()
    {
        return $this->sendRequest('GET', 'chat/emotes');
    }

    public function channel($channel)
    {
        return $this->sendRequest('GET', 'channels/'.$channel);
    }

    public function authenticatedChannel($token = null)
    {
        return $this->sendRequest('GET', 'channel', $this->getToken($token));
    }

    public function putChannel($channel, $rawOptions, $token = null)
    {
        $options = [];

        foreach ($rawOptions as $key => $value) {
            $options['channel['.$key.']'] = $value;
        }

        return $this->sendRequest('PUT', 'channels/'.$channel, $this->getToken($token), $options);
    }

    public function deleteStreamKey($channel, $token = null)
    {
        return $this->sendRequest('DELETE', 'channels/'.$channel.'/stream_key', $this->getToken($token));
    }

    public function postCommercial($channel, $length = 30, $token = null)
    {
        $availableOptions = ['length'];
        $options = ['length' => $length];

        return $this->sendRequest('POST', 'channels/'.$channel.'/commercial', $this->getToken($token), $options, $availableOptions);
    }

    public function user(string $user)
    {
        return $this->sendRequest('GET', 'users/'.$user);
    }

    public function users(array $options)
    {
        $availableOptions = ['login'];

        return $this->sendRequest('GET', 'users', false, $options, $availableOptions);
    }

    public function authenticatedUser($token = null)
    {
        return $this->sendRequest('GET', 'user', $this->getToken($token));
    }

    public function liveChannels($token = null)
    {
        return $this->sendRequest('GET', 'streams/followed', $this->getToken($token));
    }

    public function followedChannelVideos($token = null)
    {
        return $this->sendRequest('GET', 'videos/followed', $this->getToken($token));
    }

    public function searchChannels($options)
    {
        $availableOptions = ['query', 'limit', 'offset'];

        return $this->sendRequest('GET', 'search/channels', false, $options, $availableOptions);
    }

    public function streams($options)
    {
        $availableOptions = ['game', 'channel', 'limit', 'offset', 'client_id'];

        return $this->sendRequest('GET', 'streams', false, $options, $availableOptions);
    }

    public function streamsChannel($channel)
    {
        return $this->sendRequest('GET', 'streams/'.$channel);
    }

    public function streamsFeatured($options = [])
    {
        $availableOptions = ['limit', 'offset'];

        return $this->sendRequest('GET', 'streams/featured', false, $options, $availableOptions);
    }

    public function streamSummaries($options = [])
    {
        $availableOptions = ['game', 'limit', 'offset'];

        return $this->sendRequest('GET', 'streams/summary', false, $options, $availableOptions);
    }

}