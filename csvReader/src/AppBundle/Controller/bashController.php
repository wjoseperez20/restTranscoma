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

		$number = random_int(0, 100);
		$logger = LoggerFactory::getLogger(self::CLASS_NAME);
		$handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
		$logger->pushHandler($handler);

//        system('./../csvReaderDaemon.sh') . "\n";

		$logger->info('This process was started in .bashController::class into in : .bashController::numberAction()');


		//print exec("echo hola")."\n";
		return new Response('<html><body>Lucky number is :' . $number . '</body>');

	}


}