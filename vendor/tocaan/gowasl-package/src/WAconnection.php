<?php

namespace WAIntegration;
class WAconnection
{
    protected $id;
    protected $token;
    protected $identifier;

    protected static $baseUrl = 'https://app.gowasl.com/api/channels';
    function __construct(){
        $this->id = config('wa_integration.id');
        $this->token = config('wa_integration.token');
        $this->identifier = config('wa_integration.identifier');
    }

    public function startRequest($requestSegment,$type = "GET",$data=[]){

        $url = self::$baseUrl.$requestSegment;

        try {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "ID: {$this->id}",
                "TOKEN: {$this->token}",
                "Authorization: {$this->identifier}",
            ));

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $type,
                CURLOPT_POSTFIELDS => json_encode($data),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($response);

            return [
                'status'    => true,
                'code'  => 200,
                'message' => $res->message,
                'data'  => $res->data,
            ];
        }catch (\Exception $e){
            return [
                'status'    => false,
                'code'  => 500,
                'message' => $res->message,
            ];
        }
    }
}
