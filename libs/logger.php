<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * logger
 *
 * @package		LOGGER
 * @category	library
 * @author		Ankit Yadav
 * @link		
 */

class logger
{
    public $sessionId;

    public $ip_address;

    public $browser;

    public $data;

    public $requestHeaders;

    public $response;

    // db conn
    public $db;

    // db conn data
    public $db_host;
    public $db_name;
    public $db_username;
    public $db_password;

    public function __construct(String $host, String $name, String $username, String $password)
    {
        $this->db_host = trim($host);
        $this->db_name = trim($name);
        $this->db_username = trim($username);
        $this->db_password = trim($password);

        $this->sessionId = (string) uniqid() . time() . microtime();

        $this->db();
        // $this->make_table();
        $this->add_log();
    }

    public function add_log()
    {

        $this->ip_address = (string) $this->get_client_ip();
        $this->browser = json_encode($_SERVER['HTTP_USER_AGENT']);
        $this->data = json_encode(file_get_contents('php://input'));
        $this->requestHeaders = json_encode($this->getallheaders());

        $this->insert_log([
            $this->sessionId,
            $this->ip_address,
            $this->browser,
            $this->data,
            $this->requestHeaders
        ]);
    }

    protected function get_client_ip()
    {
        $ip_address = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ip_address = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ip_address = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ip_address = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ip_address = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ip_address = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ip_address = getenv('REMOTE_ADDR');
        else
            $ip_address = 'UNKNOWN';
        return $ip_address;
    }

    public function add_response(array $response)
    {
        $this->response = json_encode($response);

        $this->update_log();
    }

    public function getallheaders()
    {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if ($name != 'HTTP_MOD_REWRITE' && (substr($name, 0, 5) == 'HTTP_' || $name == 'CONTENT_LENGTH' || $name == 'CONTENT_TYPE')) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', str_replace('HTTP_', '', $name)))));
                if ($name == 'Content-Type') $name = 'Content-type';
                $headers[$name] = $value;
            }
        }
        return $headers;
    }

    protected function insert_log(array $data)
    {
        $sql = "INSERT INTO logger (sessionId, ipAddress, browser, requestData, requestHeaders)
         VALUES (?, ?, ?, ?, ?);";

        $stmt = $this->db->prepare($sql);

        $stmt->execute($data);
    }

    protected function update_log()
    {
        $sql = "UPDATE logger SET response=? WHERE sessionId=?;";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([json_encode([$this->response], true), (string) $this->sessionId]);
    }

    protected function db()
    {
        try {

            $host = $this->db_host;
            $user = $this->db_username;
            $pass = $this->db_password;
            $db = $this->db_name;
            $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    protected function make_table()
    {
        $sql = "CREATE TABLE IF NOT EXISTS logger (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sessionId VARCHAR(100) NOT NULL,
        ipAddress VARCHAR(100) NOT NULL,
        browser VARCHAR(1024) NOT NULL,
        requestData VARCHAR(1024) NOT NULL,
        requestHeaders VARCHAR(1024) NOT NULL,
        response VARCHAR(1024)  NULL,
        resp_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        req_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );";

        $this->db->exec($sql);
    }
}
