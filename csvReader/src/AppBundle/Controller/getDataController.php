<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 17/08/18
 * Time: 16:31
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Postal;

class getDataController extends FOSRestController
{

	/**
	 * Metodo que retorna todos los registros del documento
	 * DuaPartidas.csv mediante Doctrine
	 * Ejemplo: http://localhost:8000/postal
	 * @Rest\Get("/postal")
	 */
	public function getAction()
	{
		$rest_result = $this->getDoctrine()->getRepository('AppBundle:Postal')->findAll();
		if ($rest_result === null)
		{
			return new View("No existen registros dentro del documento DataPartidasDua.csv",
				Response::HTTP_NOT_FOUND);
		}
		return $rest_result;
	}

	/**
	 * metodo que retorna un registro del documento DataPartidasDua por id.
	 * ejemplo: http://localhost:8000/postal/38000
	 * @Rest\Get("/postal/{id}")
	 * @param $id
	 * @return View|null|object
	 */
	public function idAction($id)
	{
		$single_result = $this->getDoctrine()->getRepository('AppBundle:Postal')->find($id);
		if ($single_result === null)
		{
			return new View("Registro no encontrado", Response::HTTP_NOT_FOUND);
		}
		return $single_result;
	}

}