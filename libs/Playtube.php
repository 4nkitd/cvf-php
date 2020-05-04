<?php

namespace Aerro;

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

use GuzzleHttp\Client;

class Playtube
{
    /**
     * @var string
     */
    public $ApiUrl = 'https://beautyofsoul.com/api/v1.0/';

    /**
     * @var string
     */
    private $server_key;

    public function __construct(string $server_key)
    {
        $this->set_server_key($server_key);
    }

    public function set_server_key(string $server_key)
    {
        $this->server_key = $server_key;
    }

    public function register(
        string $email,
        string $username,
        string $password,
        string $Cpassword,
        string $male
    ) {
        $api_url = $this->ApiUrl . "?type=register";

        $body = array(
            'server_key' => $this->server_key,
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'confirm_password' => $Cpassword,
            'gender' => $male
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_videos()
    {
        $api_url = $this->ApiUrl . "?type=get_videos";

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_trending_videos()
    {
        $api_url = $this->ApiUrl . "?type=get_trending_videos";

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_channel_info(int $channel_id)
    {
        $api_url = $this->ApiUrl . "?type=get_channel_info&channel_id=" . $channel_id;

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_video_comments(string $video_id)
    {
        $api_url = $this->ApiUrl . "?type=get_video_comments&video_id=" . $video_id;

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_my_playlists(int $user_id, string $session_id, int $limit, int $offset = 0)
    {
        $api_url = $this->ApiUrl . "?type=get_my_playlists&limit=" . $limit;

        if ($offset > 0) {
            $api_url = $api_url . "&offset=" . $offset;
        }

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_settings(int $user_id, string $session_id)
    {
        $api_url = $this->ApiUrl . "?type=get_settings";

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function logout(int $user_id, string $session_id)
    {
        $api_url = $this->ApiUrl . "?type=logout";

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function subscribe_to_channel(int $user_id, string $session_id, string $channel_id)
    {
        $api_url = $this->ApiUrl . "?type=subscribe_to_channel&channel_id=" . $channel_id;

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_subscriptions(int $user_id, string $session_id, string $channel_id)
    {
        $api_url = $this->ApiUrl . "?type=get_subscriptions&channel=" . $channel_id;

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function add_comment(int $user_id, string $session_id, string $video_id, string $text)
    {
        $api_url = $this->ApiUrl . "?type=add_comment";

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            's' => $session_id,
            'text' => $text,
            'video_id' => $video_id
        );

        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_videos_by_category(string $category_id)
    {
        $api_url = $this->ApiUrl . "?type=get_videos_by_category&category_id=" . $category_id;

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_videos_by_channel(string $channel_id)
    {
        $api_url = $this->ApiUrl . "?type=get_videos_by_channel&" . $channel_id;

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function get_video_details(string $video_id)
    {
        $api_url = $this->ApiUrl . "?type=get_video_details&video_id=" . $video_id;

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function search(string $keyword, string $type = 'search_videos')
    {
        $api_url = $this->ApiUrl . "?" . http_build_query([
            'type' => $type,
            'keyword' => $keyword
        ]);

        $body = array(
            'server_key' => $this->server_key
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response,);
        }
    }

    public function like_dislike_video(int $user_id, string $video_id, string $action, string $session_id)
    {
        $api_url = $this->ApiUrl . "?type=like_dislike_video";

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            'video_id' => $video_id,
            'action' => $action,
            's' => $session_id
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response);
        }
    }

    public function like_dislike_comments(int $user_id, string $id, string $action, string $session_id)
    {
        $api_url = $this->ApiUrl . "?type=like_dislike_comments";

        $body = array(
            'server_key' => $this->server_key,
            'user_id' => $user_id,
            'id' => $id,
            'action' => $action,
            's' => $session_id
        );

        $status = false;

        try {

            $client = new Client();
            $res = $client->post($api_url, [
                'form_params' => $body
            ]);

            if ($res->getStatusCode() == 200) {
                $response = json_decode((string) $res->getBody());
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $response = $th->getMessage();
        } finally {
            return array('status' => $status, 'response' => $response);
        }
    }
}
