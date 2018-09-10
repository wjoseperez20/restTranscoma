<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 4/09/18
 * Time: 16:20
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

/* Factory import*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\DotenvFactory;

class PostDataController extends FOSRestController
{

    const CLASS_NAME = PostDataController::class;

    /**
     * Make a post request to a specific url with the json parameter
     * @Route("verify", name="verify")
     * @param string $send
     * @return View
     * @throws \Exception
     */
    public function requestPostAction($send)
    {
        $dotenv = DotenvFactory::getDotEnv();

        /*Indicating the .env file using an absolute path*/
        $dotenv->load(__DIR__.'/../../../.env');
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(getenv('LOG_DIRECTORY'));
        $logger->pushHandler($handler);

        /*Test url for post requests*/
        $url = getenv('URL_POST');
        try
        {
            // --- Start the connection initializing the curl object
            $connection = curl_init();
            curl_setopt($connection, CURLOPT_URL,$url);

            // --- Data is sent by POST.
            curl_setopt($connection, CURLOPT_POSTFIELDS,$send);

            // --- Header including the lenght of the senfing date.
            curl_setopt($connection, CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($send),'company:'.(getenv('COMPANY'))));

            // --- POST request.
            curl_setopt($connection, CURLOPT_POST, 1);

            // --- HTTPGET to false because its a GET request.
            curl_setopt($connection, CURLOPT_HTTPGET, FALSE);

            // -- HEADER to false.
            curl_setopt($connection, CURLOPT_HEADER, FALSE);
            $response=curl_exec($connection);
            curl_close($connection);
            return new View($response,Response::HTTP_OK);
        }
        catch (\Exception $e)
        {
            $logger
                ->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }
    }
}