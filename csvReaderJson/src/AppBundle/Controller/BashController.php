<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/* importacion de la fabrica*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\DotenvFactory;

/**
 * Class bashController
 * @package AppBundle\Controller
 */
class BashController extends Controller
{
	/**
	 * Constantes para esteblecer parametros de los loggers
	 */
	const CLASS_NAME = BashController::class;

	/**
	 * @return Response
	 * @Route("ejecutar")
	 * @throws \Exception
	 * Funcion que ejecuta el .sh desde el navegador
	 */
	public function ejecutarBashAction()
	{
        $dotenv = DotenvFactory::getDotEnv();

        /*indicando el archivo .env mediante ruta absoluta*/
        $dotenv->load('/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/.env');

        $log_directory= getenv('LOG_DIRECTORY');
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler($log_directory);
        $logger->pushHandler($handler);

		try
		{
			$mensaje= system('./../csvReaderDaemon.sh') . "\n";
			return new Response($mensaje);
		}
		catch (\RuntimeException $ee)
		{
			$logger->error("({$ee->getCode()}) Message: '{$ee->getMessage()}' in file: '{$ee->getFile()}' in line: {$ee->getLine()}");
			return new Response(" Tiempo de ejecucion excedido ". $ee, Response::HTTP_REQUEST_TIMEOUT);
		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			return new Response("No se pudo ejecutar el script ". $e, Response::HTTP_NOT_FOUND);
		}
	}
}