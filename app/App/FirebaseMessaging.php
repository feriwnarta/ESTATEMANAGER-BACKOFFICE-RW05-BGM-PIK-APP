<?php

namespace NextG\RwAdminApp\App;

class FirebaseMessaging
{
    static function sendNotif($token, $title, $body)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $serverKey = 'AAAA3Q9KXzA:APA91bGXuN0_0OxdjXOO8YIUnZ2ep3x2RYSAsjvyBQmaoyjDOfJoixzkGlmq2aflg4Q_T8-4Bq_SyOLcCEG0hfQNer-xSEEdPZjJ0dTQjBxElEJlimECL8JzLE1EW9PfXk6VFlYoHqD8';
        $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'priority' => 'high');
        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //Send the request
        $response = curl_exec($ch);
        //Close request
        if ($response === FALSE) {
            return 'error';
        } else {
            return 'success';
        }
        curl_close($ch);
    }

}