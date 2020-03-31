<?php

namespace LeoPersan;

use Exception;

class Codenation
{
    private $token;
    private $json;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getJson()
    {
        $this->json = file_get_contents('https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token='.$this->token);
        return $this->json;
    }

    public function setJson($json)
    {
        $this->json = $json;
    }

    public function putJsonInFile($filename)
    {
        return file_put_contents($filename,$this->json);
    }

    public function postFileJson($filename)
    {
        $ch = curl_init('https://api.codenation.dev/v1/challenge/dev-ps/submit-solution?token='.$this->token);

        $answer = curl_file_create($filename);

        $data = array('answer' => $answer);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);

        if (!$response) {
            $err = curl_error($ch);
            throw new Exception($err, 1);
        }

        curl_close($ch);
        return $response;
    }
}