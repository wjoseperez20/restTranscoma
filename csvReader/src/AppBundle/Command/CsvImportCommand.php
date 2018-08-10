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
            ->setDescription('Imports the mock CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Leyendo Csv...');

        $reader = Reader::createFromPath('%kernel.root_dir%/../src/AppBundle/Data/dataPartidasDua.csv');

        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();

        $io->progressStart(count($results));

        foreach ($results as $row) {

            $postalDua = (new Postal())
                ->setTrackingNumber($row['Tracking Number'])
                ->setConocimientoAereo($row['Conocimiento Aereo'])
                ->setReference($row['Reference'])
                ->setBagLabel($row['Bag Label'])
                ->setOrigin($row['Origin'])
                ->setDestination($row['Destination'])
                ->setSumaria($row['Sumaria'])
                ->setPartida($row['Partida'])
                ->setInternalAccountNumber($row['Internal Account Number'])
                ->setShipperName($row['Shipper Name'])
                ->setShipAdd1($row['Ship Add 1'])
                ->setShipAdd2($row['Ship Add 2'])
                ->setShipAdd3($row['Ship Add 3'])
                ->setCity($row['City'])
                ->setState($row['State'])
                ->setShipZip($row['Ship Zip'])
                ->setShipCountryCode($row['Ship Contry Code'])
                ->setNif($row['NIF'])
                ->setConsignee($row['Consignee'])
                ->setAddress1($row['Address1'])
                ->setAddress2($row['Address2'])
                ->setAddress3($row['Address3'])
                ->setCity($row['City'])
                ->setState($row['State'])
                ->setZip($row['Zip'])
                ->setCountryCode($row['Country Code'])
                ->setEmail($row['Email'])
                ->setPhone($row['Phone'])
                ->setPieces($row['Pieces'])
                ->setTotalWeight($row['Total Weight'])
                ->setWeightUOM($row['Weight UOM'])
                ->setTotalValue($row['Total Value'])
                ->setCurrency($row['Currency'])
                ->setIncoterms($row['Incoterms'])
                ->setService($row['Service'])
                ->setItemDescription($row['Item Description'])
                ->setItemHsCode($row['Item HS Code'])
                ->setItemQuantity($row['Item Quantity'])
                ->setItemValue($row['Item Value'])
            ;

            $this->em->persist($postalDua);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Command exited cleanly!');
    }
}