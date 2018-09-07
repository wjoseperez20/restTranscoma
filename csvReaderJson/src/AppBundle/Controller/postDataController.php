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
/* importacion de la fabrica*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\DotenvFactory;


class postDataController extends FOSRestController
{
    /**
     * Constantes para esteblecer parametros de los loggers
     */
    const CLASS_NAME = postDataController::class;

    /**
     * metodo para probar las peticiones post entrantes
     * @Rest\Post("/user/")
     */
    public function postAction(Request $request)
    {
        echo $request;

        return new View("User Added Successfully", Response::HTTP_OK);
    } // fin de postAction


    /**
     * realiza una peticion post hacia una url especificada, con el parametro en formato json
     * @Route("verificar", name="verificar")
     * @param string $envio
     * @return View
     * @throws \Exception
     */
    public function peticion_postAction($envio='{"id": 2000,"tracking_number": "PQ48K20476017570107300Z",
    "conocimiento_aereo": "20180620FDX5245772500908957","reference": "83390767643","bag_label": "LS1002315891"}')
    {
        /* Carga de variables de entorno desde el archivo.env*/
        $dotenv = DotenvFactory::getDotEnv();

        /*indicando el archivo .env mediante ruta absoluta*/
        $dotenv->load('/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/.env');
        $log_directory= getenv('LOG_DIRECTORY');
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler($log_directory);
        $logger->pushHandler($handler);

        /*url de prueba para peticiones post
        Esta url permite probar peticiones post donde se visualiza el formato json y los datos de entrada en un cuerpo
        que muestra su retorno en html. En el campo donde dice json se muestra cada elemento leido del documento en formato json
        */
        $url = "http://httpbin.org/post";
        //$url = "http://localhost:8002/user/";

        try
        {
            // --- inicia la conexion inicializando el objeto curl
            $conexion = curl_init();

            //$envio = "datos que se envian"; // --- Puede ser un xml, un json, etc.

            curl_setopt($conexion, CURLOPT_URL,$url);

            // --- Datos que se van a enviar por POST.
            curl_setopt($conexion, CURLOPT_POSTFIELDS,$envio);

            // --- Cabecera incluyendo la longitud de los datos de envio.
            curl_setopt($conexion, CURLOPT_HTTPHEADER,array('Content-Type: application/json', 'Content-Length: '.strlen($envio)));

            // --- Petición POST.
            curl_setopt($conexion, CURLOPT_POST, 1);

            // --- HTTPGET a false porque no se trata de una petición GET.
            curl_setopt($conexion, CURLOPT_HTTPGET, FALSE);

            // -- HEADER a false.
            curl_setopt($conexion, CURLOPT_HEADER, FALSE);

            // --- Respuesta.
            $respuesta=curl_exec($conexion);

            //$logger->info('la respuesta es '.$respuesta);

            // -- Cerrando conexion
            curl_close($conexion);

            return new View(' probando metodo '.$respuesta,Response::HTTP_OK);
        }
        catch (\Exception $e)
        {
            $logger
                ->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }

    }// fin de metodo postAction

}