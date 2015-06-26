<?php

namespace CanalTP\RaceServerBundle\Api;

class GoogleDirectionsApi {
    private $origin;
    private $destination;
    private $url;
    private $mode;

    public function __construct() {
        $this->url = "https://maps.googleapis.com/maps/api/directions/json";
        $this->mode = "bicycling";
    }

    public function getOrigin() {
        return $this->origin;
    }

    public function getDestination() {
        return $this->destination;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getMode() {
        return $this->mode;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
        return $this;
    }

    public function setDestination($destination) {
        $this->destination = $destination;
        return $this;
    }

    public function setUrl($url) {
        $this->url = $url;
        return $this;
    }

    public function setMode($mode) {
        $this->mode = $mode;
        return $this;
    }

    public function getRemainingDistance() {
        $result = $this->call();
        if (isset($result['routes'][0]['legs'][0]['distance']['value'])) {
            return $result['routes'][0]['legs'][0]['distance']['value'];
        }
    }

    protected function call() {
        $url = $this->url;
        $params = implode("&", array(
            "origin=".urlencode($this->origin),
            "destination=".urlencode($this->destination),
            "mode=".urlencode($this->mode),
        ));
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url.'?'.$params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}
