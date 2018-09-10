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
     * returns the instance of the logger indicating the channel name
     * @param $nameChannel
     * @return Logger
     */
    public static function getLogger($nameChannel)
    {
        return new Logger($nameChannel);
    }

    /**
     * set the location the log file
     * @param $logDirectory
     * @return StreamHandler
     * @throws \Exception
     */
    public static function getStreamHandler($logDirectory)
    {
        return new StreamHandler($logDirectory);
    }
}