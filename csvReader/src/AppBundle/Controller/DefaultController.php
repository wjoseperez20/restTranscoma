<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Document\PostalDua;
use Factory\LoggerFactory;
use Symfony\Component\Console\Style\SymfonyStyle;
use League\Csv\Reader;
//use AppBundle\Entity\Postal;

class DefaultController extends Controller
{

	/**
	 * Constantes para esteblecer parametros de los loggers
	 */
	const CLASS_NAME = DefaultController::class;
	//const LOG_DIRECTORY = '../var/logs/Controller/dev.log';
	const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/var/logs/Controller/dev.log';
	/** Ruta absoluta  */
	const CSV_DIRECTORY ='/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReader/assets/dataPartidasDua.csv';


	/**
	 * Inicia los atributos para el registro de los Loggers
	 */


	/**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	 * @Route("crear", name="crearPage")
	 */
	public function createAction()
	{
		$product = new Product();
		$product->setName('probandoi probando');
		$product->setPrice('19.99');

		$dm = $this->get('doctrine_mongodb')->getManager();
		$dm->persist($product);
		$dm->flush();

		return new Response('Created product id '.$product->getId());

	}


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

/*=========================================================================*/

	/** Metodo que retorna un documento desde la clase
	 * o coleccion Product mediante el parametro id
	 * Ejemplo:  http://localhost:8000/ver/id
	 * @Rest\Get("/ver/{id}")
	 */
	public function showAction($id)
	{
		$product = $this->get('doctrine_mongodb')
			->getRepository('AppBundle:Product')
			->find($id);

		if (!$product)
		{
			throw $this->createNotFoundException('No product found for id '.$id);
		}
		return $product;
	}

	/**
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
		//	$this->setLogger();
			//$this->logger->info('This process was started in '.CsvImportCommand::class);
	//		$io = new SymfonyStyle($input, $output);
	//		$io->title('Leyendo Csv...');
			$postalDua=null;
			$logger->info('Reading Csv file');
			$reader = Reader::createFromPath(self::CSV_DIRECTORY);
			$results = $reader->fetchAssoc();

			$dm = $this->get('doctrine_mongodb')->getManager();

	//		$io->progressStart(iterator_count($results));

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

				$dm->persist($postalDua);
			//	$io->progressAdvance();
			} //fin de foreach

			$dm->flush();
	//		$io->progressFinish();
	//		$io->success('Comando Ejecutado con Exito!');
			$logger->info('Success :  [OK] Command exited cleanly into CsvImportCommand::execute()');
			return $postalDua;

		}
		catch (\Exception $e)
		{
			$logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			throw $e;
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
			// $log->debug('The process was entered in with the pàrams: ' .CsvImportCommand::validarCadenaVacia($valor));
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
