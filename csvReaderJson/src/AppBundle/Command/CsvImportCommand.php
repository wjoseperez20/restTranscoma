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
use AppBundle\Document\DuaImport;

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

	const CLASS_NAME = CsvImportCommand::class;

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
            $dotenv = DotenvFactory::getDotEnv();
            $dotenv->load('/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderJson/.env');

            $this->log_directory= getenv('LOG_DIRECTORY_COMMAND');
            $this->csv_directory= getenv('CSV_DIRECTORY');
            $this->envio_post=ControllerFactory::getPostDataController();

		    /*instanciando los loggers*/
			$this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
			$this->handler = LoggerFactory::getStreamHandler($this->log_directory);
			$this->logger->pushHandler($this->handler);
		}
		catch (\Exception $e)
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

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            $io->title('Leyendo Csv...');
            $postalDua=null;
            $this->logger->info('Reading Csv file');
            $reader = Reader::createFromPath($this->csv_directory);
            $results = $reader->fetchAssoc();
            $io->progressStart(iterator_count($results));
            $tiempo_inicial = microtime(true); //true es para que sea calculado en segundos

            foreach ($results as $row)
            {
                $duaImport = (new DuaImport())
                    ->setTrackingNumber($this->validarCadenaVacia($row[getenv('COLUMNA1')]))
                    ->setConocimientoAereo($this->validarCadenaVacia($row[getenv('COLUMNA2')]))
                    ->setReference($this->validarCadenaVacia($row[getenv('COLUMNA3')]))
                    ->setBagLabel($this->validarCadenaVacia($row[getenv('COLUMNA4')]))
                    ->setOrigin($this->validarCadenaVacia($row[getenv('COLUMNA5')]))
                    ->setDestination($this->validarCadenaVacia($row[getenv('COLUMNA6')]))
                    ->setSumaria($this->validarCadenaVacia($row[getenv('COLUMNA7')]))
                    ->setPartida($row[getenv('COLUMNA8')])
                    ->setInternalAccountNumber($this->validarCadenaVacia($row[getenv('COLUMNA9')]))
                    ->setShipperName($this->validarCadenaVacia($row[getenv('COLUMNA10')]))
                    ->setShipAdd1($this->validarCadenaVacia($row[getenv('COLUMNA11')]))
                    ->setShipAdd2($this->validarCadenaVacia($row[getenv('COLUMNA12')]))
                    ->setShipAdd3($this->validarCadenaVacia($row[getenv('COLUMNA13')]))
                    ->setShipCity($this->validarCadenaVacia($row[getenv('COLUMNA14')]))
                    ->setShipState($this->validarCadenaVacia($row[getenv('COLUMNA15')]))
                    ->setShipZip($row[getenv('COLUMNA16')])
                    ->setShipCountryCode($this->validarCadenaVacia($row[getenv('COLUMNA17')]))
                    ->setNif($this->validarCadenaVacia($row[getenv('COLUMNA18')]))
                    ->setConsignee($this->validarCadenaVacia($row[getenv('COLUMNA19')]))
                    ->setAddress1($this->validarCadenaVacia($row[getenv('COLUMNA20')]))
                    ->setAddress2($this->validarCadenaVacia($row[getenv('COLUMNA21')]))
                    ->setAddress3($this->validarCadenaVacia($row[getenv('COLUMNA22')]))
                    ->setCity($this->validarCadenaVacia($row[getenv('COLUMNA23')]))
                    ->setState($this->validarCadenaVacia($row[getenv('COLUMNA24')]))
                    ->setZip($row[getenv('COLUMNA25')])
                    ->setCountryCode($this->validarCadenaVacia($row[getenv('COLUMNA26')]))
                    ->setEmail($this->validarCadenaVacia($row[getenv('COLUMNA27')]))
                    ->setPhone($this->validarCadenaVacia($row[getenv('COLUMNA28')]))
                    ->setPieces($row[getenv('COLUMNA29')])
                    ->setTotalWeight($row[getenv('COLUMNA30')])
                    ->setWeightUOM($this->validarCadenaVacia($row[getenv('COLUMNA31')]))
                    ->setTotalValue($this->validarCadenaVacia($row[getenv('COLUMNA32')]))
                    ->setCurrency($this->validarCadenaVacia($row[getenv('COLUMNA33')]))
                    ->setIncoterms($this->validarCadenaVacia($row[getenv('COLUMNA34')]))
                    ->setService($this->validarCadenaVacia($row[getenv('COLUMNA35')]))
                    ->setItemDescription($this->validarCadenaVacia($row[getenv('COLUMNA36')]))
                    ->setItemHsCode($row[getenv('COLUMNA37')])
                    ->setItemQuantity($row[getenv('COLUMNA38')])
                    ->setItemValue($row[getenv('COLUMNA39')]);

                $jsonContent = $serializer->serialize($duaImport, 'json');

                $this->envio_post->peticion_postAction($jsonContent);
                $io->progressAdvance();
            }

            $io->progressFinish();
            $io->success('Comando Ejecutado con Exito!');

            $tiempo_final = microtime(true);
            $tiempo_transcurrido= $tiempo_final-$tiempo_inicial;
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
		try
		{
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
	}
}