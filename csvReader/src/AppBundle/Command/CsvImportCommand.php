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
            ;

            $this->em->persist($postalDua);

            $io->progressAdvance();
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Command exited cleanly!');
    }
}