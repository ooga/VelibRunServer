<?php

namespace CanalTP\RaceServerBundle\Entity;

class Message {
    protected $name;
    protected $geoloc;
    protected $rank;
    protected $color;
    protected $progress = 0;

    public function getName() {
        return $this->name;
    }

    public function getGeoloc() {
        return $this->geoloc;
    }

    public function getRank() {
        return $this->rank;
    }

    public function getColor() {
        return $this->color;
    }

    public function getProgress() {
        return $this->progress;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setGeoloc($geoloc) {
        $this->geoloc = $geoloc;
        return $this;
    }

    public function setRank($rank) {
        $this->rank = $rank;
        return $this;
    }

    public function setColor($color) {
        $this->color = $color;
        return $this;
    }

    public function setProgress($progress) {
        $this->progress = $progress;
        return $this;
    }
}
