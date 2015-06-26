<?php

namespace CanalTP\RaceServerBundle\Builder;

use Doctrine\ORM\EntityManager;
use CanalTP\RaceServerBundle\Entity\User;
use CanalTP\RaceServerBundle\Entity\Race;
use CanalTP\RaceServerBundle\Entity\Checkpoint;
use CanalTP\RaceServerBundle\Entity\Message;

class MessageBuilder {
    private $entityManager;
    private $raceDistance;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function createMessage(Race $race) {
        $messages = array();
        $this->raceDistance = $race->getDistance();
        $userRepo = $this->entityManager->getRepository('CanalTP\RaceServerBundle\Entity\User');
        $users = $userRepo->findBy(
            array("race" => $race),
            array("id" => "ASC")
        );
//        $users = $race->getUsers();
        if ($users) {
            $checkpoints = array();
            foreach ($users as $user) {
                $checkpointRepo = $this->entityManager->getRepository('CanalTP\RaceServerBundle\Entity\Checkpoint');
                $checkpoint = $checkpointRepo->findOneBy(
                    array(
                        "race" => $race,
                        "user" => $user
                    ),
                    array("createdAt" => "DESC")
                );
                $message = $this->createMessageObject($user, $checkpoint);
                $checkpoints[] = $message->getProgress();
                $messages[] = $message;
            }
            asort($checkpoints);
            $i = 1;
            foreach ($checkpoints as $key => $value) {
                $messages[$key]->setRank($i);
                $i++;
            }
        }
        return $messages;
    }

    protected function createMessageObject(User $user, Checkpoint $checkpoint) {
        $message = new Message();
        $message->setColor($this->pickColor());
        $message->setName($user->getName());
        if ($checkpoint) {
            $message->setGeoloc(array(
                "latitude" => $checkpoint->getLatitude(),
                "longitude" => $checkpoint->getLongitude()
            ));
            $message->setProgress(
                $this->computeProgression($checkpoint->getRemainingDistance())
            );
        }
        return $message;
    }

    protected $colors = array('00CC99', 'FF33CC', '0066CC', '6666FF', '33CC33', 'CC0066', 'FF0000', '996633', '669900');
    protected $picked = array();
    protected function pickColor() {
        if ($this->colors == $this->picked) {
            $this->picked = array();
        }
        foreach ($this->colors as $color) {
            if (!in_array($color, $this->picked)) {
                $this->picked[] = $color;
                return "#".$color;
            }
        }
    }

    protected function computeProgression($distanceRemaining) {
        $distance = $this->raceDistance - $distanceRemaining;
        return $distance * 100 / $this->raceDistance;
    }
}
