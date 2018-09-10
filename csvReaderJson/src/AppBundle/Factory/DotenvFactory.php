<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 7/09/18
 * Time: 14:41
 */

namespace AppBundle\Factory;

use Symfony\Component\Dotenv\Dotenv;

class DotenvFactory
{
    /**
     * Returns the instance of the enviroment variables
     * @return Dotenv
     */
    public static function getDotEnv()
    {
        return new Dotenv();
    }

}