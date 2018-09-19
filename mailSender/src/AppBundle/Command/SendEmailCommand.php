<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 19/09/18
 * Time: 19:55
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Monolog\Logger;


/* Factory import*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\HandleFileFactory;


class SendEmailCommand extends ContainerAwareCommand
{
    const CLASS_NAME = SendEmailCommand::class;

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
     * To set or initialize the field for logging the logs
     * @throws \Exception
     */
    public function setLogger()
    {
        try
        {
            $handle_file =HandleFileFactory::getReadFileYml();
            $this->log_directory = $handle_file->getColumn('log_directory_command');
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
    protected function configure()
    {
        $this
            ->setName('send:gmail')
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
        $this->setLogger();
        $this->logger->info('This process was started in ' . SendEmailCommand::class);
        $io = new SymfonyStyle($input, $output);

        $getCol = HandleFileFactory::getReadFileYml();


    }
}