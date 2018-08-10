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

        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();

        $io->progressStart(iterator_count($results));

        foreach ($results as $row) {

            $postalDua = (new Postal())
                ->setTrackingNumber($row["TrackingNumber"])
                ->setConocimientoAereo($row["ConocimientoAereo"])
                ->setReference($row["Reference"])
                ->setBagLabel($row["BagLabel"])
                ->setOrigin($row["Origin"])
                ->setDestination($row["Destination"])
                ->setSumaria($row["Sumaria"])
                ->setPartida($row["Partida"])
                ->setInternalAccountNumber($row["InternalAccountNumber"])
                ->setShipperName($row["ShipperName"])
                ->setShipAdd1($row["ShipAdd1"])
                ->setShipAdd2($row["ShipAdd2"])
                ->setShipAdd3($row["ShipAdd3"])
                ->setCity($row["City"])
                ->setState($row["State"])
                ->setShipZip($row["ShipZip"])
                ->setShipCountryCode($row["ShipContryCode"])
                ->setNif($row["NIF"])
                ->setConsignee($row["Consignee"])
                ->setAddress1($row["Address1"])
                ->setAddress2($row["Address2"])
                ->setAddress3($row["Address3"])
                ->setCity($row["City"])
                ->setState($row["State"])
                ->setZip($row["Zip"])
                ->setCountryCode($row["CountryCode"])
                ->setEmail($row["Email"])
                ->setPhone($row["Phone"])
                ->setPieces($row["Pieces"])
                ->setTotalWeight($row["TotalWeight"])
                ->setWeightUOM($row["WeightUOM"])
                ->setTotalValue($row["TotalValue"])
                ->setCurrency($row["Currency"])
                ->setIncoterms($row["Incoterms"])
                ->setService($row["Service"])
                ->setItemDescription($row["ItemDescription"])
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
}