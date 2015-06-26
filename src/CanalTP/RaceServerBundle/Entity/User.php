<?php

namespace CanalTP\RaceServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="user_idx", columns={"device_id"})})
 * @ORM\HasLifecycleCallbacks()
 */
class User {
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
    protected $deviceId;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="CanalTP\RaceServerBundle\Entity\Race", inversedBy="users")
     * @ORM\JoinColumn(name="race_id", referencedColumnName="id")
     **/
    protected $race;

    /**
     * @ORM\OneToMany(targetEntity="CanalTP\RaceServerBundle\Entity\Checkpoint", mappedBy="race", cascade={"persist"})
     */
    protected $checkpoints;

    public function getId() {
        return $this->id;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getDeviceId() {
        return $this->deviceId;
    }

    public function getName() {
        return $this->name;
    }

    public function getRace() {
        return $this->race;
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

    public function setDeviceId($deviceId) {
        $this->deviceId = $deviceId;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setRace($race) {
        $this->race = $race;
        return $this;
    }

    public function setCheckpoints($checkpoints) {
        $this->checkpoints = $checkpoints;
        return $this;
    }

    public function addCheckpoint($checkpoint) {
        $this->checkpoints[] = $checkpoint;
        $checkpoint->setUser($this);
        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist() {
        $this->createdAt = new \DateTime();
    }
}
