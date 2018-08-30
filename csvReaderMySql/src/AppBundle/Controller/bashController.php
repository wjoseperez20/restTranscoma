<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use Factory\LoggerFactory3;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class bashController
 * @package AppBundle\Controller
 */
class bashController extends Controller
{
	/**
	 * Constantes para esteblecer parametros de los loggers
	 */
	const CLASS_NAME = bashController::class;
	//const LOG_DIRECTORY = '../var/logs/Controller/dev.log';
	const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/var/logs/Controller/dev.log';

	/**
	 * @return Response
	 * @Route("ejecutar")
	 * @throws \Exception
	 * Genera numeros aleatorios y ejecuta el .sh
	 */
	public function numberAction()
	{
//		$logger = LoggerFactory3::getLogger(self::CLASS_NAME);
//		$handler = LoggerFactory3::getStreamHandler(self::LOG_DIRECTORY);
//		$logger->pushHandler($handler);
		try
		{
			$number = random_int(0, 100);

			system('./../csvReaderDaemon.sh') . "\n";

			//$logger->info('This process was started in .bashController::class into in : .bashController::numberAction()');

			//print exec("echo hola")."\n";
			return new Response('<html><body>Lucky number is :' . $number .	' .</body>');
		}
		catch (\RuntimeException $ee)
		{
//			$logger->error("({$ee->getCode()}) Message: '{$ee->getMessage()}' in file: '{$ee->getFile()}' in line: {$ee->getLine()}");
			return new Response(" Tiempo de ejecucion excedido ". $ee, Response::HTTP_REQUEST_TIMEOUT);
			throw $ee;
		}
		catch (\Exception $e)
		{
//			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			return new Response("Registro no encontrado ". $e, Response::HTTP_NOT_FOUND);
			throw $e;
		}
	}// fin de numberAction

}//fin de la clase