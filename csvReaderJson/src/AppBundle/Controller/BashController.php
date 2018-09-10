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

/* Factory import */
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\DotenvFactory;

/**
 * Class BashController
 * @package AppBundle\Controller
 */
class BashController extends Controller
{

	const CLASS_NAME = BashController::class;

	/**
	 * @return Response
	 * @Route("execute")
	 * @throws \Exception
	 * This run the .sh from the browser
	 */
	public function runBashAction()
	{
        $dotenv = DotenvFactory::getDotEnv();

        /*indicating the ,env file using absolute path*/
        $dotenv->load(__DIR__.'/../../../.env');
        $log_directory= getenv('LOG_DIRECTORY');
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler($log_directory);
        $logger->pushHandler($handler);

		try
		{
			$message= system('./../csvReaderDaemon.sh') . "\n";
			return new Response($message);
		}
		catch (\RuntimeException $ee)
		{
			$logger->error("({$ee->getCode()}) Message: '{$ee->getMessage()}' in file: '{$ee->getFile()}' in line: {$ee->getLine()}");
			return new Response(" Execution time exceeded ". $ee, Response::HTTP_REQUEST_TIMEOUT);
		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			return new Response("The script could not be executed ". $e, Response::HTTP_NOT_FOUND);
		}
	}
}