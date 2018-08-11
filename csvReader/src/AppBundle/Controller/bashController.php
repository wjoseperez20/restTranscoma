<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class bashController
 * @package AppBundle\Controller
 */
class bashController extends Controller
{
    /**
     * @return Response
     * @Route("Lucky/number")
     * @throws \Exception
     */
    public function numberAction()
    {
        $number = random_int(0,100);
       // system(..\);
        system( './../csvReaderDaemon.sh')."\n";
        //print exec("echo hola")."\n";
        return new Response('<html><body>Lucky number is :'.$number. '</body>');
    }


}