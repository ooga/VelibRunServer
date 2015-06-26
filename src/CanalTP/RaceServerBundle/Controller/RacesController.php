<?php

namespace CanalTP\RaceServerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use CanalTP\RaceServerBundle\Entity\Race;

class RacesController extends FOSRestController
{
    public function getRacesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findAll();
        return new View($datas);
    }

    public function getRaceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findBy(
            array('id' => $id)
        );
        return new View($datas);
    }

    public function postRaceAction(Request $request)
    {
        $code = 400;
        $race = new Race();
        if ($request->request->has('name')) {
            $race->setName($request->request->get('name'));

            $em = $this->getDoctrine()->getManager();
            $em->persist($race);
            $em->flush();
            $code = 201;
        }
        return new View($race->getId(), $code);
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
