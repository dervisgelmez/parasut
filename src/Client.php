<?php

namespace Parasut;

class Client
{
    /**
     * @return string
     */
    const BASE_URL = 'https://api.parasut.com/v4';

    /**
     * @var string
     */
    const API_TOKEN_URL = 'https://api.parasut.com/oauth/token';

    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $services = [
        'account'  => Service\Account::class,
        'contact'  => Service\Contact::class,
        'category' => Service\Category::class,
        'employee' => Service\Employee::class,
        'invoice'  => Service\Invoice::class,
        'product'  => Service\Product::class,
    ];

    /**
     * @var array
     */
    private $build = [];



    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function authorize()
    {
        $connect = $this->send(self::API_TOKEN_URL, $this->getConfig(), 'POST', ['realUrl']);
        if (is_array($connect)) {
            $token = $this->getArray($connect, 'access_token');
            $this->token = ($token) ? $token : null;

            return $this;
        }
        return null;
    }

    public function open($request)
    {
        $service = $this->getArray($this->services, $request);
        $build = $this->getArray($this->build, $request);
        if ($build) {
            return $build;
        }
        if ($service) {
            return $this->build[$request] = new $service($this, $request);
        }
        return false;
    }

    public function send($url, $body = null, $method = 'GET', $filter = array())
    {
        $headers = [];
        $query = null;

        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.$this->token;

        if (!in_array('realUrl', $filter)) {
            $url = $this->generateUrl($url);
        }
        if (is_array($body)) {
            $query = '?'.http_build_query($body);
        }
        if (is_string($body)) {
            $query = '/'.$body;
        }

        $url = $url.($method === 'GET' ? $query : null);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        switch ($method) {
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                break;
        }
        $jsonData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = json_decode($jsonData, true);
        curl_close($ch);

        switch ($httpCode) {
            case '400':
                return strlen($jsonData) < 3 ? $msg = 'Bad Request' : $jsonData;
                break;
            case '401':
                return strlen($jsonData) < 3 ? $msg = 'Authentication Error' : $jsonData;
                break;
            case '404':
                return strlen($jsonData) < 3 ? $msg = 'Not Found Error' : $jsonData;
                break;
            case '422':
                return strlen($jsonData) < 3 ? $msg = 'Unprocessable Entity Error' : $jsonData;
                break;
            case '500':
                return strlen($jsonData) < 3 ? $msg = 'Internal Server Error' : $jsonData;
                break;
            default:
                return $response;
                break;
        }
    }

    public function getConfig($key = null)
    {
        if (!$key) {
            return $this->config;
        }
        return $this->getArray($this->config, $key);
    }

    private function getArray($array, $key = null)
    {
        if (is_null($key)) {
            return $array;
        }
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        return null;
    }

    private function generateUrl($request = null)
    {
        $request = ($request != null) ? '/'.$request : null;
        return self::BASE_URL.'/'.$this->getConfig('company_id').$request;
    }
}

?>
