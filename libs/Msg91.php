<?php

namespace Aerro;

/* 
    * @author     : 4nkitd@github
    * @authorName : Ankit
*/

use GuzzleHttp\Client;

class Msg91
{
    /**
     * @var string
     */
    public $ApiUrl = 'https://api.msg91.com/api/';

    /**
     * @var string
     */
    private $authKey;

    public function __construct(string $authKey)
    {
        $this->set_auth_key($authKey);
    }

    public function set_auth_key(string $authKey)
    {
        $this->authKey = $authKey;
    }

    public function sms(
        $body = '{
        "sender": "SOCKET",
        "route": "1",
        "country": "91",
        "sms": [
          {
            "message": "test of lapp1",
            "to": [
              "9999999999"
            ]
          }
        ]
      }'
    ) {
        $api_url = $this->ApiUrl . "v2/";

        $status = false;

        try {
            $client = new Client(['base_uri' => $api_url]);
            $res = $client->request('POST', 'sendsms', [
                'body' => $body,
                'headers'  => [
                    'authkey' => $this->authKey,
                    'Content-Type' => 'application/json'
                ],
            ]);
            if ($res->getStatusCode() == 200) {
                $msg = $res->getBody();
                $status = true;
            } else {
                throw new \Exception('Failed : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
        } finally {
            return array('status' => $status, 'msg' => $msg,);
        }
    }

    public function otp(
        string $mobile,
        string $template_id,
        string $extra_param
    ) {
        $api_url = $this->ApiUrl . "v5/otp?";

        $body = 'authkey=' . $this->authKey .
            '&template_id=' . $template_id .
            '&extra_param=' . $extra_param .
            '&mobile=' . $mobile;

        $status = false;

        try {
            $client = new Client();
            $res = $client->get($api_url . $body);

            if ($res->getStatusCode() == 200) {
                $msg = (string) $res->getBody();
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
        } finally {
            return array('status' => $status, 'msg' => $msg,);
        }
    }

    public function resendOtp(
        $mobile = '+919999999999'
    ) {
        $api_url = $this->ApiUrl . "v5/otp/retry?";

        $body = 'mobile=' . $mobile .
            '&authkey=' . $this->authKey;


        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url . $body);

            if ($res->getStatusCode() == 200) {
                $msg = (string) $res->getBody();
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
        } finally {
            return array('status' => $status, 'msg' => $msg,);
        }
    }

    public function verifyOtp(
        $mobile = '+919999999999',
        $otp = '5250'
    ) {
        $api_url = $this->ApiUrl . "v5/otp/verify?";

        $body = 'mobile=' . $mobile .
            '&authkey=' . $this->authKey .
            '&otp=' . $otp;


        $status = false;

        try {
            $client = new Client();
            $res = $client->post($api_url . $body);

            if ($res->getStatusCode() == 200) {
                $msg = (string) $res->getBody();
                $status = true;
            } else {
                throw new \Exception($res->getStatusCode() . ' : ' . serialize($res));
            }
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
        } finally {
            return array('status' => $status, 'msg' => $msg,);
        }
    }
}
