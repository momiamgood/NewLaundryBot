<?php
namespace Base;
require 'Configs/telegram.php';

class Request
{
    protected $apiURL = "https://api.telegram.org/bot" . $token;

    /** Отправляем запрос в Телеграмм
     * @param $payload
     * @param $method
     * @return mixed
     */
    public function request($method, $payload)
    {
        $response = '';

        if (is_array($payload)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiURL . '/' . $method);
            curl_setopt($ch, CURLOPT_POST, count($payload));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);
        }

        return json_decode($response, true);
    }
}