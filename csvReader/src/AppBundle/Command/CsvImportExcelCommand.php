<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 9/08/18
 * Time: 21:41
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Style\SymfonyStyle;

class CsvImportExcelCommand extends Command
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

         * metodo que permite establecer el nombre del comando
         */
    protected function configure()
    {
        $this
            //the name of command (the part after "bin/console")
            ->setName('csv:excel')

            // this short description shown while running "php bin/console list"
            ->setDescription('Leer un archivo csv y guardarlo en la base de datos.')

            // the full command description shown when running the command with
            // the "--help" option
           // ->setHelp('This command allows you to save a file with csv format...')
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
        $io->title('Attempting import of Feed...');
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([ 'Lector archivo excel ','============','', ]);

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
       //para establecer algun metodo
        // $output->writeln($this->someMethod());

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

    }


}