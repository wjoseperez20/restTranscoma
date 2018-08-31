<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 17/08/18
 * Time: 16:31
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Factory\LoggerFactory;


class getDataController extends FOSRestController
{
	/**
	 * Constantes para esteblecer parametros de los loggers
	 */
	const CLASS_NAME = bashController::class;
	//const LOG_DIRECTORY = '../var/logs/Controller/dev.log';
	const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderMySql/var/logs/Controller/dev.log';


	/**
	 *  @throws \Exception
	 * Metodo que retorna todos los registros del documento
	 * DuaPartidas.csv mediante Doctrine desde mysql
	 * Ejemplo:  http://localhost:8000/consultar
	 * @Rest\Get("/consultar")
	 */
	public function getAction()
	{
		$logger = LoggerFactory::getLogger(self::CLASS_NAME);
		$handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
		$logger->pushHandler($handler);
		try
		{
			$rest_result = $this->getDoctrine()->getRepository('AppBundle:Postal')->findAll();
			if (($rest_result === null) ||(!$rest_result))
			{
				return new View("No existen registros dentro de la base de datos Mysql en la tabla Postal",
					Response::HTTP_NOT_FOUND);
			}
			return $rest_result;
		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: 
			{$e->getLine()} into getDataController::getAction");
			return new View("Registro no encontrado. Hay una excepcion: ". $e, Response::HTTP_NOT_FOUND);
		}
	}

	/**
	 * metodo que retorna un registro del documento DataPartidasDua por id.
	 * ejemplo: http://localhost:8000/consultar/38000
	 * @Rest\Get("/consultar/{id}")
	 * @param $idw
	 * @return View|null|object
	 * @throws \Exception
	 */
	public function idAction($id)
	{
		$logger = LoggerFactory::getLogger(self::CLASS_NAME);
		$handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
		$logger->pushHandler($handler);
		try
		{
			$rest_result = $this->getDoctrine()->getRepository('AppBundle:Postal')->find($id);
			if ($rest_result === null)
			{
				return new View("No se encontro el registro con el id: ".$id,
					Response::HTTP_NOT_FOUND);
			}
			return $rest_result;
		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: 
			{$e->getLine()} into getDataController::getAction con el id: ".$id);
			return new View("Registro no encontrado. Hay una excepcion: ". $e ."con el id: ".$id, Response::HTTP_NOT_FOUND);
		}
	}

}