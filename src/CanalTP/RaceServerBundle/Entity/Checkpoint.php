<?php

namespace CanalTP\RaceServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="checkpoints")
 * @ORM\HasLifecycleCallbacks()
 */
class Checkpoint {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    protected $latitude;

    /**
     * @ORM\Column(type="float")
     */
    protected $longitude;

    /**
     * @ORM\Column(type="float")
     */
    protected $altitude;

    /**
     * @ORM\Column(type="float")
     */
    protected $accuracy;

    /**
     * @ORM\Column(type="float")
     */
    protected $speed;

    /**
     * @ORM\Column(type="integer")
     */
    protected $remainingDistance;

    /**
     * @ORM\ManyToOne(targetEntity="CanalTP\RaceServerBundle\Entity\User", inversedBy="checkpoints")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="CanalTP\RaceServerBundle\Entity\Race", inversedBy="checkpoints")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     **/
    protected $race;

    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getAltitude() {
        return $this->altitude;
    }

    public function getAccuracy() {
        return $this->accuracy;
    }

    public function getSpeed() {
        return $this->speed;
    }

    public function getRemainingDistance() {
        return $this->remainingDistance;
    }

    public function getUser() {
        return $this->user;
    }

    public function getRace() {
        return $this->race;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    public function setAltitude($altitude) {
        $this->altitude = $altitude;
        return $this;
    }

    public function setAccuracy($accuracy) {
        $this->accuracy = $accuracy;
        return $this;
    }

    public function setSpeed($speed) {
        $this->speed = $speed;
        return $this;
    }

    public function setRemainingDistance($remainingDistance) {
        $this->remainingDistance = $remainingDistance;
        return $this;
    }

    public function setUser($user) {
        $this->user = $user;
        return $this;
    }

    public function setRace($race) {
        $this->race = $race;
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist() {
        $this->createdAt = new \DateTime();
    }
}
