<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 12/09/18
 * Time: 22:55
 */

namespace AppBundle\Factory;


use AppBundle\Command\HandleFile\ReadFileYml;

class HandleFileFactory
{
    /**
     * Returns the instance of the ReadFileYml
     * @return ReadFileYml
     */
    public static function getReadFileYml()
    {
        return new ReadFileYml();
    }
}