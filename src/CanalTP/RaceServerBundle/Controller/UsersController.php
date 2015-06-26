<?php

namespace CanalTP\RaceServerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use CanalTP\RaceServerBundle\Entity\User;

class UsersController extends FOSRestController
{
    public function getUsersAction($race_id)
    {
        $em = $this->getDoctrine()->getManager();
        $datas = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findOneBy(
            array('id' => $race_id)
        );
        return new View($datas->getUsers());
    }

    public function postUserAction(Request $request, $race_id)
    {
        $code = 400;
        $user = new User();
        if ($request->request->has('uiid') && $request->request->has('name')) {
            $em = $this->getDoctrine()->getManager();
            $uiid = $request->request->get('uiid');
            $dbUser = $em->getRepository('CanalTP\RaceServerBundle\Entity\User')->findOneBy(
                array('deviceId' => $uiid)
            );
            if ($dbUser) {
                $user = $dbUser;
                $code = 200;
            } else {
                $user->setDeviceId($uiid);
                $code = 201;
            }
            $user->setName($request->request->get('name'));
            $race = $em->getRepository('CanalTP\RaceServerBundle\Entity\Race')->findOneBy(
                array('id' => $race_id)
            );
            $race->addUser($user);
            $em->persist($race);
            $em->flush();
        }
        return new View($user->getId(), $code);
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
