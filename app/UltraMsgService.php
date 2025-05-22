<?php

namespace App;

class UltraMsgService
{
    protected $sid;
    protected $token;
    protected $client;

    public function __construct()
    {
        $this->sid = env('ULTRAMSG_SID');
        $this->token = env('ULTRAMSG_TOKEN');
//        $this->client = new WhatsAppApi($this->token, $this->sid);
    }

    public function sendSMS($to, $message)
    {
//        try {


            $params = array(
                'token' => $this->token,
                'to' => $to,
                'body' => $message
            );
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/".$this->sid."/messages/chat",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
dd($response);
            if ($err) {
                return false;
            } else {
                return true;
            }
//            $this->client->sendChatMessage($to,$message);
//            return true;
//        } catch (\Exception $e) {
//            return false;
//        }
    }
}
