<?php

namespace AppBundle\Command;

use AppBundle\Entity\Postal;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

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
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
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
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Leyendo Csv...');

        $reader = Reader::createFromPath('%kernel.root_dir%/../assets/dataPartidasDua.csv');
        //%kernel.root_dir%/../src/AppBundle/Data/dataPartidasDua.csv
        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();

        $io->progressStart(iterator_count($results));

        foreach ($results as $row) {

            $postalDua = (new Postal())
                ->setTrackingNumber($this->validarCadenaVacia($row["TrackingNumber"]))
                ->setConocimientoAereo($this->validarCadenaVacia($row["ConocimientoAereo"]))
                ->setReference($this->validarCadenaVacia($row["Reference"]))
                ->setBagLabel($this->validarCadenaVacia($row["BagLabel"]))
                ->setOrigin($this->validarCadenaVacia($row["Origin"]))
                ->setDestination($this->validarCadenaVacia($row["Destination"]))
                ->setSumaria($this->validarCadenaVacia($row["Sumaria"]))
                ->setPartida($row["Partida"])
                ->setInternalAccountNumber($this->validarCadenaVacia( $row["InternalAccountNumber"]))
                ->setShipperName($this->validarCadenaVacia( $row["ShipperName"]))
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
                ->setItemValue($row["ItemValue"])
            ;

            $this->em->persist($postalDua);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Command exited cleanly!');
    }


    /**
     * valida si el valor dentro del documentp es vacio, escribe null
     * en la base de datos
     * @param $valor
     * @return string
     */
    public function validarCadenaVacia($valor){
        if(trim($valor) == ''){
            return 'NULL';
        }else{
            return $valor;
        }
    }
}