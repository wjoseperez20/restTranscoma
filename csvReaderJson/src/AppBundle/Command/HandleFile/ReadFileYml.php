<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 12/09/18
 * Time: 18:14
 */

namespace AppBundle\Command\HandleFile;

use Monolog\Logger;
use Symfony\Component\Yaml\Yaml;

/* Factory import */
use AppBundle\Factory\LoggerFactory;


class ReadFileYml
{

    const CLASS_NAME = ReadFileYml::class;

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
     * This reads the file "config_document" to set the name of the columns from document, using the $column param, to
     * indicate the column name and its return your value.
     * @param $column
     * @return the given value from the column param
     * @throws \Exception
     */
    public function getColumn($column)
    {
        try
        {
            $value =Yaml::parseFile(__DIR__ . '/../../../../parameters.yml');
            $val = $value[$column];
            return $val;
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} with the param {$column}");
            throw $e;
        }
    }
}