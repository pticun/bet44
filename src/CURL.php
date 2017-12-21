<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 08/12/2017
 * Time: 22:21
 */

class CURL
{
    public $url = null;
    protected $curl = null;
    public $response = null;

    public function __construct($url, $return_transfer = true, $method = null)
    {
//        die('https://www.oddschecker.com/football/english/premier-league/west-ham-v-chelsea/half-time');
//        echo file_get_contents('https://www.oddschecker.com/football/english/premier-league/west-ham-v-chelsea/half-time');die;
        $this->url = $url;
        $this->curl = curl_init($url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, $return_transfer);
        curl_setopt($this->curl, CURLOPT_HEADER, true);
//        curl_setopt($this->curl, CURLOPT_PORT, 443);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        if (!empty($method)) {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        }

//        curl_setopt($this->curl, CURLOPT_URL, $this->url);
//        curl_setopt($this->curl, CURLOPT_HEADER, TRUE);
//        curl_setopt($this->curl, CURLOPT_NOBODY, TRUE); // remove body
//        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
//        $head = curl_exec($this->curl);
//        $httpCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
//        curl_close($ch);
    }

    public function exec()
    {
        $this->response = curl_exec($this->curl);
    }

    public function get_response()
    {
        return $this->response;
    }

    public function close()
    {
        curl_close($this->curl);
    }
}
