<?php

namespace CanalTP\RaceServerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\OneToMany(targetEntity="CanalTP\RaceServerBundle\Entity\User", mappedBy="race", cascade={"persist"})
     */
    protected $users;

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

    public function getName() {
        return $this->name;
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
    }
}
