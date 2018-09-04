<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 31/08/18
 * Time: 19:04
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Document\PostalDua;
use AppBundle\Factory\LoggerFactory;
use League\Csv\Reader;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;



class InsertDataController extends FOSRestController
{

    /**
     * Constantes para esteblecer parametros de los loggers
     */
    const CLASS_NAME = DefaultController::class;

    /** Ruta absoluta  */
    const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/var/logs/Controller/dev.log';
    const CSV_DIRECTORY ='/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/assets/dataPartidasDua.csv';


    /**
     * Funcion que lee el documento DuaPartidasCsv y guarda todos los registros dentro
     * de la base de datos mongodb.
     * Retorna un response con el estado de la insercion
     * @Route("insertar", name="insertarCsv")
     * @throws \Exception
     */
    public function insertAction()
    {
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);

        try
        {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            //$this->setLogger();
            //$this->logger->info('This process was started in '.CsvImportCommand::class);
            //$io = new SymfonyStyle($input, $output);
            //$io->title('Leyendo Csv...');
            $postalDua=null;
            $logger->info('Reading Csv file');
            $reader = Reader::createFromPath(self::CSV_DIRECTORY);
            $results = $reader->fetchAssoc();
            //$dm = $this->get('doctrine_mongodb')->getManager();

            //$io->progressStart(iterator_count($results));

            foreach ($results as $row)
            {
                $postalDua = (new PostalDua())
                    ->setTrackingNumber($this->validarCadenaVacia($row["TrackingNumber"]))
                    ->setConocimientoAereo($this->validarCadenaVacia($row["ConocimientoAereo"]))
                    ->setReference($this->validarCadenaVacia($row["Reference"]))
                    ->setBagLabel($this->validarCadenaVacia($row["BagLabel"]))
                    ->setOrigin($this->validarCadenaVacia($row["Origin"]))
                    ->setDestination($this->validarCadenaVacia($row["Destination"]))
                    ->setSumaria($this->validarCadenaVacia($row["Sumaria"]))
                    ->setPartida($row["Partida"])
                    ->setInternalAccountNumber($this->validarCadenaVacia($row["InternalAccountNumber"]))
                    ->setShipperName($this->validarCadenaVacia($row["ShipperName"]))
                    ->setShipAdd1($this->validarCadenaVacia($row["ShipAdd1"]))
                    ->setShipAdd2($this->validarCadenaVacia($row["ShipAdd2"]))
                    ->setShipAdd3($this->validarCadenaVacia($row["ShipAdd3"]))
                    ->setShipCity($this->validarCadenaVacia($row["ShipCity"]))
                    ->setShipState($this->validarCadenaVacia($row["ShipState"]))
                    ->setShipZip($row["ShipZip"])
                    ->setShipCountryCode($this->validarCadenaVacia($row["ShipContryCode"]))
                    ->setNif($this->validarCadenaVacia($row["NIF"]))
                    ->setConsignee($this->validarCadenaVacia($row["Consignee"]))
                    ->setAddress1($this->validarCadenaVacia($row["Address1"]))
                    ->setAddress2($this->validarCadenaVacia($row["Address2"]))
                    ->setAddress3($this->validarCadenaVacia($row["Address3"]))
                    ->setCity($this->validarCadenaVacia($row["City"]))
                    ->setState($this->validarCadenaVacia($row["State"]))
                    ->setZip($row["Zip"])
                    ->setCountryCode($this->validarCadenaVacia($row["CountryCode"]))
                    ->setEmail($this->validarCadenaVacia($row["Email"]))
                    ->setPhone($this->validarCadenaVacia($row["Phone"]))
                    ->setPieces($row["Pieces"])
                    ->setTotalWeight($row["TotalWeight"])
                    ->setWeightUOM($this->validarCadenaVacia($row["WeightUOM"]))
                    ->setTotalValue($this->validarCadenaVacia($row["TotalValue"]))
                    ->setCurrency($this->validarCadenaVacia($row["Currency"]))
                    ->setIncoterms($this->validarCadenaVacia($row["Incoterms"]))
                    ->setService($this->validarCadenaVacia($row["Service"]))
                    ->setItemDescription($this->validarCadenaVacia($row["ItemDescription"]))
                    ->setItemHsCode($row["ItemHSCode"])
                    ->setItemQuantity($row["ItemQuantity"])
                    ->setItemValue($row["ItemValue"]);
                $jsonContent = $serializer->serialize($postalDua, 'json');
                echo $jsonContent;
//                $jsonContentD =$serializer->deserialize($jsonContent,'json');
//               echo 33333333333333333333333333333333333333333333333333333333;
//                echo $jsonContentD;

               // return new View('probando json'.$jsonContent,Response::HTTP_OK);
              // return $postalDua;
                // $dm->persist($postalDua);
                //$io->progressAdvance();
            } //fin de foreach

         //   $dm->flush();
            //$io->progressFinish();
            //$io->success('Comando Ejecutado con Exito!');
        //    $logger->info('Success :  [OK] Command exited cleanly into CsvImportCommand::insertAction');
            return new View('Success :  [OK] Command exited cleanly into CsvImportCommand::insertAction',Response::HTTP_OK);

        }
        catch (\Exception $e)
        {
            $logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            //throw $e;
            return new View('Unsuccessful insertion into CsvImportCommand::execute(). The exception is:'.$e,Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally
        {
            $logger->info('The process was finally into DefaultController::class');
        }
    }


    /**
     * Valida si el valor dentro del documento es vacio, escribe null
     * en la base de datos, de lo contrario retorna su valor
     * @param $valor
     * @return string
     * @throws \Exception
     */
    public function validarCadenaVacia($valor)
    {
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);
        try
        {
            if (trim($valor) == '')
                return 'NULL';
            else
                return $valor;
        }
        catch (\Exception $e)
        {
            $logger
                ->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }

    }// fin validarCadenaVacia
}


//------------------------------------------------- Estructura Post ----------------------------------------------
//	/**
//	 * @Rest\Post("/user/")
//	 */
//	public function postAction(Request $request)
//	{
//		$product = new Product();
//		$name = $request->get('name');
//		$price = $request->get('price');
//
//		if(empty($name) || empty($price))
//		{
//			return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
//		}
//		$product->setName($name);
//		$product->setPrice($price);
//
//		$dm = $this->get('doctrine_mongodb')->getManager();
//		$dm->persist($product);
//		$dm->flush();
//
//		return new View('Created product id ',Response::HTTP_OK);
//	}

///*=========================================================================*/