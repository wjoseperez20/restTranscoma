<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 4/09/18
 * Time: 16:20
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;


class postDataController extends FOSRestController
{

    /**
     * @Rest\Post("/user/")
     */
    public function postAction(Request $request)
    {
        echo $request;
//        $data = new User;
//        $name = $request->get('name');
//        $role = $request->get('role');
//        if(empty($name) || empty($role))
//        {
//            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
//        }
//        $data->setName($name);
//        $data->setRole($role);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($data);
//        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
    }

}