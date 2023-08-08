<?php

namespace NextG\RwAdminApp\Services\WablasServices\Impl;

use NextG\RwAdminApp\Services\WablasServices\WablasService;

class WablasServiceImpl implements WablasService
{

    private $token = 'd440185ImAQSnbiUgDIp9owIdrYPIGTd1ERlxjPfETLIgZ89UEshc4WDOe2FKAut';
    private $curl;

    public function __construct()
    {
        $this->curl = curl_init();
        curl_setopt(
            $this->curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $this->token",
                "url: https://pati.wablas.com",
            )
        );
    }

    public function reportRealtime()
    {
        $page = '1';
        $message_id = '';
        $limit = '10';


        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_URL,  "https://pati.wablas.com/api/report-realtime?page=$page&message_id=$message_id&limit=$limit");
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($this->curl);
        $status = json_decode($result, true);
        return $status;
    }

    public function checkDeviceActive()
    {
        curl_setopt($this->curl, CURLOPT_URL,  "https://pati.wablas.com/api/device/info?token=$this->token");
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($this->curl);
        $result = json_decode($result, true);
        return $result['data']['status'];
    }

    public function sendText($phoneNumber, $message)
    {
        $data = [
            'phone' => $phoneNumber,
            'message' => $message,
            'secret' => true,
            'prioprity' => true,
        ];

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($this->curl, CURLOPT_URL,  "https://pati.wablas.com/api/send-message");
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($this->curl);
        $result = json_decode($result, true);



        return $result['status'];
    }

    public function deviceScan()
    {
        $url = "https://pati.wablas.com/api/device/scan?token=$this->token";
        return $url;
        // curl_setopt($this->curl, CURLOPT_URL,  "https://pati.wablas.com/api/device/scan?token=$this->token");
        // curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "GET");
        // curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        // $result = curl_exec($this->curl);
        // return $result;
    }

    public function sendMultipleText($payload)
    {
        curl_setopt(
            $this->curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $this->token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($this->curl, CURLOPT_URL,  "https://pati.wablas.com/api/v2/send-message");
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($this->curl);
        $result = json_decode($result, true);
        return $result['status'];
    }

    private function curlClose()
    {
        curl_close($this->curl);
    }
}
