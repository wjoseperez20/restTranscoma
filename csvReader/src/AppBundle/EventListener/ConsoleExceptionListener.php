<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 14/08/18
 * Time: 17:14
 */

namespace AppBundle\EventListener;

use Symfony\Component\Console\Event\ConsoleExceptionEvent;
use Psr\Log\LoggerInterface;

class ConsoleExceptionListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function onConsoleException(ConsoleExceptionEvent $event)
    {
        $command = $event->getCommand();
        $exception = $event->getException();

        $message = sprintf(
            '%s: %s (uncaught exception) at %s line %s while running console command `%s`',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $command->getName()
        );

        $this->logger->error($message, array('exception' => $exception));
    }
    public function exampleMethod($ourVar)
    {
        $this->logger->debug('probando debg detalle');
        $this->logger->info('empezando logueo ejemplo ');
        $this->logger->notice('normal pero eventos significativos', ['our_var'=>$ourVar]);

    }

}