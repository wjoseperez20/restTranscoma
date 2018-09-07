<?php

namespace AppBundle\Command;


use Doctrine\ORM\EntityManagerInterface;

use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Monolog\Logger;
use AppBundle\Document\PostalDua;

/* importacion de la fabrica*/
use AppBundle\Factory\DotenvFactory;
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\ControllerFactory;

/* para serializar objetos*/
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class CsvImportCommand extends ContainerAwareCommand
{
	/**
	 * Constantes para esteblecer parametros de los loggers
	 */
	const CLASS_NAME = CsvImportCommand::class;

	//const LOG_DIRECTORY = 'var/logs/Command/dev.log';
	const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/var/logs/Command/dev.log';

	/**
	 * Constante para definir la ubicacion del documento
	 * DUA que se encuentra en formato CSV
	 * Ruta absoluta
	 */
	const CSV_DIRECTORY ='/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/assets/dataPartidasDua.csv';

	/**
	 * @var EntityManagerInterface
	 */
	private $em;

	/**
	 * @var logger
	 */
	private $logger;

	/**
	 * @var $handler
	 */
	private $handler;

    /**
     * @var
     */
	private $log_directory;

    /**
     * @var
     */
	private $csv_directory;

    /**
     * @var
     */
	private $envio_post;

	/**
	 * Metodo que establece o inicializa los campos para el registro de los logger
	 * @throws \Exception
	 */
	public function setLogger()
	{
		try
		{
            /* Carga de variables de entorno desde el archivo.env*/
            $dotenv = DotenvFactory::getDotEnv();

            /*indicando el archivo .env mediante ruta absoluta*/
            $dotenv->load('/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/.env');

            $this->log_directory= getenv('LOG_DIRECTORY_COMMAND');
            $this->csv_directory= getenv('CSV_DIRECTORY');

            $this->envio_post=ControllerFactory::getPostDataController();

		    /*instanciando los loggers*/
			$this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
			$this->handler = LoggerFactory::getStreamHandler($this->log_directory);
			$this->logger->pushHandler($this->handler);
		}
		catch (Exception $e)
		{
			$this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			throw $e;
		}
	}


	/**
	 * CsvImportCommand constructor.
	 *
	 * @param EntityManagerInterface $em
	 *
	 * @throws \Symfony\Component\Console\Exception\LogicException
	 */
	public function __construct(EntityManagerInterface $em)
	{
		parent::__construct();
		$this->em = $em;

	}

	/**
	 * Configure para definir el comando csv:import
	 * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
	 * @throws \Exception
	 */
	protected function configure()
	{
		$this
			->setName('csv:import')
			->setDescription('Importa un CSV, y lo guarda en Base de Datos');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return void
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		try
        {
            $this->setLogger();
            $this->logger->info('This process was started in '.CsvImportCommand::class);
            $this->envio_post=ControllerFactory::getPostDataController();
            $io = new SymfonyStyle($input, $output);

            /*Codifica un objeto en Json para este caso*/
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $io->title('Leyendo Csv...');
            $postalDua=null;
            $this->logger->info('Reading Csv file');
            $reader = Reader::createFromPath($this->csv_directory);
            $results = $reader->fetchAssoc();

            /*Obtener el repositorio de doctrine mongodb ubicado dentro de config.yml*/
           // $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();

            $io->progressStart(iterator_count($results));

            /*Marcando el tiempo inicial para la lectura del documento*/
            $tiempo_inicial = microtime(true); //true es para que sea calculado en segundos


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

                //$jsonContentD =$serializer->deserialize($jsonContent,'json');

                //Llamando a la funcion peticion_post
                $this->envio_post->peticion_postAction($jsonContent);
                //$dm->persist($postalDua);

                $io->progressAdvance();
            } //fin de foreach

          //  $dm->flush();
            $io->progressFinish();
            $io->success('Comando Ejecutado con Exito!');

            /*marcando el tiempo actual luego de haber terminado el programa*/
            $tiempo_final = microtime(true);

            /* Mostrado en segundos*/
            $tiempo_transcurrido= $tiempo_final-$tiempo_inicial;

            /* tiempo en minutos*/
            $tiempo_transcurrido_min= $tiempo_transcurrido/60;

            $this->logger->info('Success : Tardo en realizar la lectura : '.$tiempo_transcurrido.' seg. equivalente a '.$tiempo_transcurrido_min.' minutos. into CsvImportCommand::insertAction');

		}
		catch (\Exception $e)
		{
			$this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			throw $e;
		}
		finally
		{
			$this->logger->info('The process was finally into CsvImportCommand::execute()');
		}
	}// fin de execute


	/**
	 * Valida si el valor dentro del documento es vacio, escribe null
	 * en la base de datos, de lo contrario retorna su valor
	 * @param $valor
	 * @return string
	 * @throws \Exception
	 */
	public function validarCadenaVacia($valor)
	{
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
			$this->logger
				->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
			throw $e;
		}
	}// fin validarCadenaVacia
}