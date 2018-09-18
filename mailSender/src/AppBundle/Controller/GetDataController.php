<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 31/08/18
 * Time: 18:57
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Document\PostalDua;
use AppBundle\Factory\LoggerFactory;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class getDataController
 * @package AppBundle\Controller
 */
class GetDataController extends FOSRestController
{
    /**
     * Constantes para esteblecer parametros de los loggers
     */
    const CLASS_NAME = DefaultController::class;

    /** Ruta absoluta  */
    const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderMongoDB/var/logs/Controller/dev.log';
    const CSV_DIRECTORY ='/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderMongoDB/assets/dataPartidasDua.csv';


    /**
     * metodo que retorna todos registro del documento DataPartidasDua
     * desde la base de datos de mongodb en la coleccion PostalDua ubicado dentro de Document
     * ejemplo: http://localhost:8000/consultar
     * @Rest\Get("/consultar/")
     * @return View|null|object
     * @throws \Exception
     */
    public function queryAction()
    {

        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);
        try
        {
            $csv = $this->get('doctrine_mongodb')
                ->getRepository('AppBundle:PostalDua')
                ->findAll();
            if (!$csv)
            {
                throw $this->createNotFoundException('No records found.');
            }
            return $csv;
        }
        catch (\Exception $e)
        {
            $logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            GetDataController");
            return new View("Registro no encontrado ". $e, Response::HTTP_NOT_FOUND);
            // throw $e;
        }
    }// fin de queryAction


    /**
     * metodo que retorna un registro del documento DataPartidasDua por id.
     * desde mongodb en la coleccion PostalDua dentro de Document
     * ejemplo: http://localhost:8000/consultar
     * @Rest\Get("/consultar/{id}")
     * @return View|null|object
     * @throws \Exception
     * @param $id
     */
    public function querySpecificAction($id)
    {
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);
        try
        {
            $csv = $this->get('doctrine_mongodb')
                ->getRepository('AppBundle:PostalDua')
                ->find($id);

            if (!$csv)
            {
                throw $this->createNotFoundException('No records found. ');
            }
            return $csv;
        }
        catch (\Exception $e)
        {
            $logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            return new View("Registro no encontrado ". $e, Response::HTTP_NOT_FOUND);
            // throw $e;
        }
    }// fin de QuerySpecificAction
}