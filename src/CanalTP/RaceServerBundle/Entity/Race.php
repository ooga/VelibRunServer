<?php

namespace CanalTP\RaceServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CanalTP\RaceServerBundle\Api\GoogleDirectionsApi;

/**
 * @ORM\Entity
 * @ORM\Table(name="races")
 * @ORM\HasLifecycleCallbacks()
 */
class Race {
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
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $origin;

    /**
     * @ORM\Column(type="string")
     */
    protected $destination;

    /**
     * @ORM\Column(type="integer")
     */
    protected $distance;

    /**
     * @ORM\OneToMany(targetEntity="CanalTP\RaceServerBundle\Entity\User", mappedBy="race", cascade={"persist"})
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="CanalTP\RaceServerBundle\Entity\Checkpoint", mappedBy="race", cascade={"persist"})
     */
    protected $checkpoints;

    public function __construct() {
        $this->origin = "20 Rue Hector Malot, 75012 Paris, France";
        $this->destination = "Cathédrale Notre-Dame de Paris, 6 Parvis Notre-Dame - Pl. Jean-Paul II, 75004 Paris";
    }

    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getName() {
        return $this->name;
    }

    public function getOrigin() {
        return $this->origin;
    }

    public function getDestination() {
        return $this->destination;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function getUsers() {
        return $this->users;
    }

    public function getCheckpoints() {
        return $this->checkpoints;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setOrigin($origin) {
        $this->origin = $origin;
        return $this;
    }

    public function setDestination($destination) {
        $this->destination = $destination;
        return $this;
    }

    public function setDistance($distance) {
        $this->distance = $distance;
        return $this;
    }

    public function setUsers($users) {
        $this->users = $users;
        return $this;
    }

    public function setCheckpoints($checkpoints) {
        $this->checkpoints = $checkpoints;
        return $this;
    }

    public function addUser($user) {
        $this->users[] = $user;
        $user->setRace($this);
        return $this;
    }

    public function addCheckpoint($checkpoint) {
        $this->checkpoints[] = $checkpoint;
        $checkpoint->setRace($this);
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist() {
        $this->createdAt = new \DateTime();
        $api = new GoogleDirectionsApi();
        $api->setOrigin($this->origin);
        $api->setDestination($this->destination);
        $this->distance = $api->getRemainingDistance();
    }
}
