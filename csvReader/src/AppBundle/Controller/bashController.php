<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use Factory\LoggerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
	const LOG_DIRECTORY = '../var/logs/Controller/dev.log';

	/**
	 * @return Response
	 * @Route("Lucky/number")
	 * @throws \Exception
	 */
	public function numberAction()
	{
		try
		{
			$number = random_int(0, 100);
			$logger = LoggerFactory::getLogger(self::CLASS_NAME);
			$handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
			$logger->pushHandler($handler);

			system('./../csvReaderDaemon.sh') . "\n";

			$logger->info('This process was started in .bashController::class into in : .bashController::numberAction()');

			//print exec("echo hola")."\n";
			return new Response('<html><body>Lucky number is :' . $number .	' .</body>');
		}
		catch (RuntimeException $ee)
		{
			return new Response(" Tiempo de ejecucion excedido ". $ee, Response::HTTP_REQUEST_TIMEOUT);
			$logger->error("({$ee->getCode()}) Message: '{$ee->getMessage()}' in file: '{$ee->getFile()}' in line: {$ee->getLine()}");
			throw $ee;
		}
		catch (Exception $e)
		{
			return new Response("Registro no encontrado ". $e, Response::HTTP_NOT_FOUND);
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			throw $e;
		}



	}


}