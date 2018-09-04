<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 16/08/18
 * Time: 16:59
 */

namespace AppBundle\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class LoggerFactory
{
    /**
     * retorna la instancia del Logger indicando el nombre del canal
     * @param $nameChannel
     * @return Logger
     */
    public static function getLogger($nameChannel)
    {
        return new Logger($nameChannel);
    }

    /**
     * establece la ubicacion del log
     * @param $logDirectory
     * @return StreamHandler
     * @throws \Exception
     */
    public static function getStreamHandler($logDirectory)
    {
        return new StreamHandler($logDirectory);
    }
}