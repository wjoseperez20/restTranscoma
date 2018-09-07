<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 7/09/18
 * Time: 15:53
 */

namespace AppBundle\Factory;


use AppBundle\Controller\postDataController;

class ControllerFactory
{
    /**
     * Returna la instancia de la carga de las variables de entorno
     * @return postDataController
     */
    public static function getPostDataController()
    {
        return new postDataController();
    }
}