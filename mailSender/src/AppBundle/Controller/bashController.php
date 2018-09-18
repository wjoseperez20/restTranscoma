<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use AppBundle\Document\Mail;
use AppBundle\Factory\LoggerFactory;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class bashController
 * @package AppBundle\Controller
 */
class bashController extends Controller
{
    /**
     * Constantes para esteblecer parametros de los loggers
     */
    const CLASS_NAME = bashController::class;
    //const LOG_DIRECTORY = '../var/logs/Controller/dev.log';
    const LOG_DIRECTORY = '/home/maggie/Documentos/Aplicaciones/symfonyRest/restTranscoma/csvReaderMongoDB/var/logs/Controller/dev.log';

    /**
     * @Route("crear")
     * @throws \Exception
     * @return Response
     */
    public function createAction()
    {
        $mail = new Mail();
        $mail->setSmtp('smtp.gmail.com');
        $mail->setUsuario('jdyepescash@gmail.com');

        $mail->setClave('trascenduniversal');
        $mail->setAsunto('Prueba envio correo ososoos');
        $mail->setFrom('jdyepescash@gmail@gmail.com');
        $mail->setTo('jesusdyepes@gmail.com');
        $mail->setBody(' Para el envio hay que permitir el uso de aplicaciones no seguras: https://myaccount.google.com/lesssecureapps');
        $mail->setRead(false);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($mail);
        $dm->flush();

        return new Response('Created mailer id ' . $mail->getId());
    }

    /**
     * @param $id
     * @param $value
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function updateReadFieldAction($id, $value)
    {
        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);
        try {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $mail = $dm->getRepository('AppBundle:Mail')->find($id);

            if (!$mail) {
                throw $this->createNotFoundException('No mail found for id ' . $id);
            }

            $mail->setRead($value);
            $dm->flush();
        } catch (\Exception $e) {
            $logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            GetDataController");
            return new View("Registro no encontrado " . $e, Response::HTTP_NOT_FOUND);
            // throw $e;
        }
        return $this->redirect($this->generateUrl('homepage'));
    }


    /**
     * metodo que retorna todos registro del documento DataPartidasDua
     * desde la base de datos de mongodb en la coleccion PostalDua ubicado dentro de Document
     * ejemplo: http://localhost:8000/consultar
     * @Rest\Get("/obtener/")
     * @return View|null|object
     * @throws \Exception
     */
    public function readDBMongo()
    {


        $logger = LoggerFactory::getLogger(self::CLASS_NAME);
        $handler = LoggerFactory::getStreamHandler(self::LOG_DIRECTORY);
        $logger->pushHandler($handler);
        try {
            $csv = $this->get('doctrine_mongodb')
                ->getRepository('AppBundle:Mail')
                ->findAll();
            if (!$csv) {
                throw $this->createNotFoundException('No records found.');
            }
            // $obj= json_decode($csv);
            return $csv;
        } catch (\Exception $e) {
            $logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            GetDataController");
            return new Response("Registro no encontrado " . $e, Response::HTTP_NOT_FOUND);
            // throw $e;
        }
    }

    /**
     * metodo que retorna todos registro del documento DataPartidasDua
     * desde la base de datos de mongodb en la coleccion PostalDua ubicado dentro de Document
     * ejemplo: http://localhost:8000/consultar
     * @Rest\Get("/cursor/")
     * @return View|null|object
     * @throws \Exception
     */
    public function readCursor()
    {
        try {

            $content = $this->readDBMongo();
            $mes = null;
            $id = null;

            foreach ($content as $item) {
//                $mes="el id es " . $item->getBody();
                // var_dump($item);
                $id = $item->getId();
                $smtp = $item->getSmtp();
                $port = 587;
                $usuario = $item->getUsuario();
                $clave = $item->getClave();
                $encry = 'tls';
                $asunto = $item->getAsunto();
                $from = $item->getFrom();
                $To = $item->getTo();
                $body = $item->getBody();
                // print_r($item->getTo());
                $leido = $item->getRead();
                if ($leido === false) {
                    $this->sendMail($smtp, $port, $usuario, $clave, $encry, $asunto, $from, $To, $body);
                    //  $this->updateReadFieldAction($id,true);

                } else {
                    $mes = ' Ya este correo fue leido con el item: ';
                }

            }
            return $mes;
        } catch (\Exception $e) {
            return $e;
        }

    }

    /**
     * @param $smtp
     * @param $port
     * @param $userName
     * @param $userPasswd
     * @param $encryption
     * @param $subject
     * @param $from
     * @param $to
     * @param $body
     * @return Response
     * @Rest\Route("send")
     */
    public function sendMail($smtp, $port, $userName, $userPasswd, $encryption, $subject, $from, $to, $body)
    {
// gmail. 587 and encription tls

        $transport = \Swift_SmtpTransport::newInstance()
            ->setHost($smtp)
            ->setPort($port)
            ->setUsername($userName)
            ->setEncryption($encryption)
            ->setPassword($userPasswd);
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body);
        $mailer->send($message);

//        if($mailer->send($message))
        return new Response(' Se envio el email');
//        else
//            return new Response(' no se envio el email');
    }


    /**
     * @return Response
     * @Rest\Route("send")
     */
    public function indexAction()
    {

        $transport = \Swift_SmtpTransport::newInstance()
            ->setHost('smtp.gmail.com')
            ->setPort(587)
            ->setUsername('jdyepescash@gmail.com')
            //   ->setAuthMode('login')
            ->setEncryption('tls')
            ->setPassword('trascenduniversal');
        $mailer = \Swift_Mailer::newInstance($transport);
        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email wilmer')
            ->setFrom('jesusyepes.1205@gmail.com')
            ->setTo('jesusdyepes@gmail.com')
            ->setBody(' el cuerpo del mensaje es este.
           Para el envio hay que permitir el uso de aplicaciones no seguras:
           https://myaccount.google.com/lesssecureapps'
            );
        //    $this->get('mailer')->send($message);

        $mailer->send($message);
//        if($mailer->send($message))
        return new Response(' Se envio el email');
//        else
//            return new Response(' no se envio el email');
    }
}//fin de la clase