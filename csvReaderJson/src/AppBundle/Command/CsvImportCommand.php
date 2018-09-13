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
use AppBundle\Models\DuaImport;

/* Factory import*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\ControllerFactory;
use AppBundle\Factory\HandleFileFactory;

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
            $handle_file =HandleFileFactory::getReadFileYml();
            $this->log_directory = $handle_file->getColumn('log_directory_command');
            $this->csv_directory=$handle_file->getColumn('csv_directory');
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
        try {
            $this->setLogger();
            $this->logger->info('This process was started in ' . CsvImportCommand::class);
            $this->send_post = ControllerFactory::getPostDataController();
            $io = new SymfonyStyle($input, $output);

            $finder = new Finder();
            $finder->files()->in($this->csv_directory)->name('*.csv')->exclude('csvRead');
            $fileSystem = new Filesystem();

            if (!($fileSystem->exists($this->csv_directory . 'csvRead'))) {
                $fileSystem->mkdir($this->csv_directory . 'csvRead');
            }

            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $getCol = HandleFileFactory::getReadFileYml();

            foreach ($finder as $file) {

                if (file_get_contents($file)){

                    $io->title('Reading .csv ...');
                    $postalDua = null;
                    $this->logger->info('Reading ' . $file->getFilename() .' file');
                    $reader = Reader::createFromPath($file);
                    $results = $reader->fetchAssoc();
                    $io->progressStart(iterator_count($results));
                    $start_time = microtime(true); //true is in seconds
                    $pos=0;// pos =0 to indicate the first row, -1 to indicate that the document could not be read
                    foreach ($results as $row) {
                            if ((count($row) >= getenv('CABECERAS'))) {
                                $duaImport = (new DuaImport())
                                    ->setTrackingNumber($this->validateEmptyString($row[(string)$getCol->getColumn('column1')]))
                                    ->setConocimientoAereo($this->validateEmptyString($row[(string)$getCol->getColumn('column2')]))
                                    ->setReference($this->validateEmptyString($row[(string)$getCol->getColumn('column3')]))
                                    ->setBagLabel($this->validateEmptyString($row[(string)$getCol->getColumn('column4')]))
                                    ->setOrigin($this->validateEmptyString($row[(string)$getCol->getColumn('column5')]))
                                    ->setDestination($this->validateEmptyString($row[(string)$getCol->getColumn('column6')]))
                                    ->setSumaria($this->validateEmptyString($row[(string)$getCol->getColumn('column7')]))
                                    ->setPartida($row[(string)$getCol->getColumn('column8')])
                                    ->setInternalAccountNumber($this->validateEmptyString($row[(string)$getCol->getColumn('column9')]))
                                    ->setShipperName($this->validateEmptyString($row[(string)$getCol->getColumn('column10')]))
                                    ->setShipAdd1($this->validateEmptyString($row[(string)$getCol->getColumn('column11')]))
                                    ->setShipAdd2($this->validateEmptyString($row[(string)$getCol->getColumn('column12')]))
                                    ->setShipAdd3($this->validateEmptyString($row[(string)$getCol->getColumn('column13')]))
                                    ->setShipCity($this->validateEmptyString($row[(string)$getCol->getColumn('column14')]))
                                    ->setShipState($this->validateEmptyString($row[(string)$getCol->getColumn('column15')]))
                                    ->setShipZip($row[(string)$getCol->getColumn('column16')])
                                    ->setShipCountryCode($this->validateEmptyString($row[(string)$getCol->getColumn('column17')]))
                                    ->setNif($this->validateEmptyString($row[(string)$getCol->getColumn('column18')]))
                                    ->setConsignee($this->validateEmptyString($row[(string)$getCol->getColumn('column19')]))
                                    ->setAddress1($this->validateEmptyString($row[(string)$getCol->getColumn('column20')]))
                                    ->setAddress2($this->validateEmptyString($row[(string)$getCol->getColumn('column21')]))
                                    ->setAddress3($this->validateEmptyString($row[(string)$getCol->getColumn('column22')]))
                                    ->setCity($this->validateEmptyString($row[(string)$getCol->getColumn('column23')]))
                                    ->setState($this->validateEmptyString($row[(string)$getCol->getColumn('column24')]))
                                    ->setZip($row[(string)$getCol->getColumn('column25')])
                                    ->setCountryCode($this->validateEmptyString($row[(string)$getCol->getColumn('column26')]))
                                    ->setEmail($this->validateEmptyString($row[(string)$getCol->getColumn('column27')]))
                                    ->setPhone($this->validateEmptyString($row[(string)$getCol->getColumn('column28')]))
                                    ->setPieces($row[(string)$getCol->getColumn('column29')])
                                    ->setTotalWeight($row[(string)$getCol->getColumn('column30')])
                                    ->setWeightUOM($this->validateEmptyString($row[(string)$getCol->getColumn('column31')]))
                                    ->setTotalValue($this->validateEmptyString($row[(string)$getCol->getColumn('column32')]))
                                    ->setCurrency($this->validateEmptyString($row[(string)$getCol->getColumn('column33')]))
                                    ->setIncoterms($this->validateEmptyString($row[(string)$getCol->getColumn('column34')]))
                                    ->setService($this->validateEmptyString($row[(string)$getCol->getColumn('column35')]))
                                    ->setItemDescription($this->validateEmptyString($row[(string)$getCol->getColumn('column36')]))
                                    ->setItemHsCode($row[(string)$getCol->getColumn('column37')])
                                    ->setItemQuantity($row[(string)$getCol->getColumn('column38')])
                                    ->setItemValue($row[(string)$getCol->getColumn('column39')]);
                                $jsonContent = $serializer->serialize($duaImport, 'json');
                                $this->send_post->requestPostAction($jsonContent);
                                $output->writeln(sprintf("\033\143" ));
                                $output->writeln(sprintf('Processing file reading Csv'."\n"));
                                $io->progressAdvance();
                                $pos++;
                            } elseif ((count($row) < 39) && $pos === 0) {
                                $pos = -1; // if not is complete the headers from document
                            }
                        }
                    if($pos!=-1) {
                        $this->logger->info('The file ' . $file->getFilename() . ' was read successfully');
                        $fileSystem->copy(($this->csv_directory) . $file->getFilename(), ($this->csv_directory . ('csvRead/')) . $file->getFilename());
                        $fileSystem->remove(($this->csv_directory) . $file->getFilename());
                        $io->progressFinish();
                        $io->success('Command Executed with Success!');
                        $end_time = microtime(true);
                        $elapsed_time = $end_time - $start_time;
                        $elapsed_time_min = $elapsed_time / 60;
                        $this->logger->info('Success : Reading time : ' . $elapsed_time_min . ' min. into CsvImportCommand::insertAction');
                    }
                    else {
                        $output->writeln("\n");
                        $io->note('The document ' . $file->getFilename() . ' reading can not be processed. Check if the headers are complete.');
                        $this->logger->info('The document ' . $file->getFilename() . ' reading can not be processed. Check if the headers are complete.');
                    }
                }
                elseif (file_get_contents($file) !== false)
                {
                    $this->logger->info('The file '.$file->getFilename() .' is empty. Removing the empty file');
                    $fileSystem->remove(($this->csv_directory) . $file->getFilename());
                }
            }
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