<?php

namespace CanalTP\RaceServerBundle\Service;


class GcmService {
    protected $apiKey = '';
    protected $topic = 'global';
    protected $serverUrl = 'https://gcm-http.googleapis.com/gcm/send';

    function getApiKey() {
        return $this->apiKey;
    }

    function getTopic() {
        return $this->topic;
    }

    function setApiKey($apiKey) {
        $this->apiKey = $apiKey;
        return $this;
    }

    function setTopic($topic) {
        $this->topic = $topic;
        return $this;
    }

    public function send(array $message) {
        $headers = array(
            'Content-Type: application/json',
            'Authorization: key='.$this->apiKey
        );

        $datas = array(
            'to' => '/topics/'.$this->getTopic(),
            'data' => $message
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->serverUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datas));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response  = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
