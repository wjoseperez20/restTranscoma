<?php

namespace AppBundle\Command;


use Doctrine\ORM\EntityManagerInterface;

use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Monolog\Logger;
use AppBundle\Document\DuaImport;

/* Factory import*/
use AppBundle\Factory\DotenvFactory;
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\ControllerFactory;

/* to serialize objects*/
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
    private $send_post;

    /**
     * To set or initialize the field for logging the logs
     * @throws \Exception
     */
    public function setLogger()
    {
        try
        {
            $dotenv = DotenvFactory::getDotEnv();
            $dotenv->load(__DIR__ . '/../../../.env');

            $this->log_directory = getenv('LOG_DIRECTORY_COMMAND');
            $this->csv_directory = getenv('CSV_DIRECTORY');
            $this->send_post = ControllerFactory::getPostDataController();

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
     * Configure to define the csv:import command
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     * @throws \Exception
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Reads from the .csv and sends it as json');
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
            $this->logger->info('This process was started in ' . CsvImportCommand::class);
            $this->send_post = ControllerFactory::getPostDataController();
            $io = new SymfonyStyle($input, $output);

            $finder = new Finder();
            $finder->files()->in($this->csv_directory)->name('*.csv')->exclude('csvRead');
            $fileSystem = new Filesystem();

            if(!($fileSystem->exists($this->csv_directory.'csvRead'))){
                $fileSystem->mkdir($this->csv_directory.'csvRead');
            }

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);

            foreach ($finder as $file)
            {
                $io->title('Reading .csv ...');
                $postalDua = null;
                $this->logger->info('Reading ' . $file->getFilename() . 'file');
                $reader = Reader::createFromPath($file);
                $results = $reader->fetchAssoc();
                $io->progressStart(iterator_count($results));
                $start_time = microtime(true); //true es para que sea calculado en segundos

                foreach ($results as $row)
                {
                    $duaImport = (new DuaImport())
                        ->setTrackingNumber($this->validateEmptyString($row[getenv('COLUMNA1')]))
                        ->setConocimientoAereo($this->validateEmptyString($row[getenv('COLUMNA2')]))
                        ->setReference($this->validateEmptyString($row[getenv('COLUMNA3')]))
                        ->setBagLabel($this->validateEmptyString($row[getenv('COLUMNA4')]))
                        ->setOrigin($this->validateEmptyString($row[getenv('COLUMNA5')]))
                        ->setDestination($this->validateEmptyString($row[getenv('COLUMNA6')]))
                        ->setSumaria($this->validateEmptyString($row[getenv('COLUMNA7')]))
                        ->setPartida($row[getenv('COLUMNA8')])
                        ->setInternalAccountNumber($this->validateEmptyString($row[getenv('COLUMNA9')]))
                        ->setShipperName($this->validateEmptyString($row[getenv('COLUMNA10')]))
                        ->setShipAdd1($this->validateEmptyString($row[getenv('COLUMNA11')]))
                        ->setShipAdd2($this->validateEmptyString($row[getenv('COLUMNA12')]))
                        ->setShipAdd3($this->validateEmptyString($row[getenv('COLUMNA13')]))
                        ->setShipCity($this->validateEmptyString($row[getenv('COLUMNA14')]))
                        ->setShipState($this->validateEmptyString($row[getenv('COLUMNA15')]))
                        ->setShipZip($row[getenv('COLUMNA16')])
                        ->setShipCountryCode($this->validateEmptyString($row[getenv('COLUMNA17')]))
                        ->setNif($this->validateEmptyString($row[getenv('COLUMNA18')]))
                        ->setConsignee($this->validateEmptyString($row[getenv('COLUMNA19')]))
                        ->setAddress1($this->validateEmptyString($row[getenv('COLUMNA20')]))
                        ->setAddress2($this->validateEmptyString($row[getenv('COLUMNA21')]))
                        ->setAddress3($this->validateEmptyString($row[getenv('COLUMNA22')]))
                        ->setCity($this->validateEmptyString($row[getenv('COLUMNA23')]))
                        ->setState($this->validateEmptyString($row[getenv('COLUMNA24')]))
                        ->setZip($row[getenv('COLUMNA25')])
                        ->setCountryCode($this->validateEmptyString($row[getenv('COLUMNA26')]))
                        ->setEmail($this->validateEmptyString($row[getenv('COLUMNA27')]))
                        ->setPhone($this->validateEmptyString($row[getenv('COLUMNA28')]))
                        ->setPieces($row[getenv('COLUMNA29')])
                        ->setTotalWeight($row[getenv('COLUMNA30')])
                        ->setWeightUOM($this->validateEmptyString($row[getenv('COLUMNA31')]))
                        ->setTotalValue($this->validateEmptyString($row[getenv('COLUMNA32')]))
                        ->setCurrency($this->validateEmptyString($row[getenv('COLUMNA33')]))
                        ->setIncoterms($this->validateEmptyString($row[getenv('COLUMNA34')]))
                        ->setService($this->validateEmptyString($row[getenv('COLUMNA35')]))
                        ->setItemDescription($this->validateEmptyString($row[getenv('COLUMNA36')]))
                        ->setItemHsCode($row[getenv('COLUMNA37')])
                        ->setItemQuantity($row[getenv('COLUMNA38')])
                        ->setItemValue($row[getenv('COLUMNA39')]);

                $jsonContent = $serializer->serialize($duaImport, 'json');//
                $this->send_post->requestPostAction($jsonContent);
                $output->writeln(sprintf("\033\143". "\n"));
                $output->writeln(sprintf("\033\143"));
                $output->writeln(sprintf('Processing file reading Csv'));
                $io->progressAdvance();
                }

                $this->logger->info('The file '. $file->getFilename().' was read successfully');
                $fileSystem->copy(($this->csv_directory).$file->getFilename(),($this->csv_directory.('csvRead/')).$file->getFilename());
                $fileSystem->remove(($this->csv_directory).$file->getFilename());
            }
            $io->progressFinish();
            $io->success('Command Executed with Success!');
            $end_time = microtime(true);
            $elapsed_time = $end_time - $start_time;
            $elapsed_time_min = $elapsed_time / 60;
            $this->logger->info('Success : Reading time : ' . $elapsed_time_min . ' min. into CsvImportCommand::insertAction');
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
     * Validates if the value inside the document is empty, write nuul,
     * otherwise returns its value
     * @param $value
     * @return string
     * @throws \Exception
     */
    public function validateEmptyString($value)
    {
        try
        {
            if (trim($value) == '')
                return 'NULL';
            else
                return $value;
        }
        catch (\Exception $e)
        {
            $this->logger
                ->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }
    }
}