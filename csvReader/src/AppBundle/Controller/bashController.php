<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Monolog\Handler\StreamHandler;

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

        $number = random_int(0, 100);

        // system(..\);
        //  $obj = new bashController();
        system('./../csvReaderDaemon.sh') . "\n";
        $logger = $this->get('logger');
        $logger->info('This process was started in '.bashController::class);

//        $logger->err('An error occurredffff');
//        $logger->alert('An error occurredffff');
//        $logger->emergency('An error occurredffff');
//        $logger->warning('An error occurredffff');
//        $logger->critical('I left the oven on!', array(
//            // include extra "context" info in your logs
//            'cause' => 'in_hurry',
//        ));


        //print exec("echo hola")."\n";
        return new Response('<html><body>Lucky number is :' . $number . '</body>');
    }


}