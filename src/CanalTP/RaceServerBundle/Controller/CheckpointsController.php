<?php

namespace CanalTP\RaceServerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use CanalTP\RaceServerBundle\Entity\Checkpoint;

class CheckpointsController extends FOSRestController
{
    public function getCheckpointsAction($race_id)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findOneBy(
            array('id' => $race_id)
        );
        return new View($datas->getCheckpoints());
    }

    public function postCheckpointAction(Request $request, $race_id)
    {
        $code = 400;
        $checkpoint = new Checkpoint();
        if ($request->request->has('uiid') && $request->request->has('lat') &&
            $request->request->has('lon') && $request->request->has('alt') &&
            $request->request->has('accur') && $request->request->has('speed')) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('CanalTP\RaceServerBundle\Entity\User')->findOneBy(
                array('deviceId' => $request->request->get('uiid'))
            );
            if ($user) {
                $code = 201;
                $checkpoint->setAccuracy($request->request->get('accur'));
                $checkpoint->setAltitude($request->request->get('alt'));
                $checkpoint->setLatitude($request->request->get('lat'));
                $checkpoint->setLongitude($request->request->get('lon'));
                $checkpoint->setSpeed($request->request->get('speed'));
                $race = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findOneBy(
                    array('id' => $race_id)
                );
                $user->addCheckpoint($checkpoint);
                $race->addCheckpoint($checkpoint);
                $em->persist($race);
                $em->flush();
            }
        }
        return new View($checkpoint->getId(), $code);
    }

    public function postMessageAction()
    {
        $gcm = $this->get("canal_tp_race_server.gcm");
        $response = $gcm->send(array(
            "message" => "test from service"
        ));

        return new View($response);
    }
}
