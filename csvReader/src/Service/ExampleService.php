<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 15/08/18
 * Time: 20:49
 */

namespace Service;

use Psr\Log\LoggerInterface;

class ExampleService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExampleService constructor.
     * @param $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function exampleMethod($ourVar)
    {
        $this->logger->debug('probando debg detalle');
        $this->logger->info('empezando logueo ejemplo ');
        $this->logger->notice('normal pero eventos significativos', ['our_var'=>$ourVar]);

    }

}