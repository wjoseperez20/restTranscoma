<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use AppBundle\Document\Mail;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Factory\HandleFileFactory;
use AppBundle\Factory\LoggerFactory;
use Monolog\Logger;

/**
 * Class mongoDBController
 * @package AppBundle\Controller
 */
class MongoDBController extends Controller
{
    /**
     * Constantes para esteblecer parametros de los loggers
     */
    const CLASS_NAME = MongoDBController::class;

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
    private  $handle_file;

    /**
     * @var
     */
    private $log_directory;

    /**
     * This initialize the loggers, then to register into catch exception in controller folder
     */
    public function setLogger()
    {
        $this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
        try
        {
            $this->handle_file =HandleFileFactory::getReadFileYml();
            $this->log_directory= $this->handle_file->getColumn('log_directory_controller');
            $this->handler = LoggerFactory::getStreamHandler($this->log_directory);
            $this->logger->pushHandler($this->handler);
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
        }
    }

    /**
     * @Route("crear")
     * @throws \Exception
     * @return Response
     */
    public function createAction()
    {
        $this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
        try
        {
        $mail = new Mail();
        $mail->setSmtp('smtp.gmail.com');
        $mail->setUsuario('jdyepescash@gmail.com');
        $mail->setClave('trascenduniversal');
        $mail->setAsunto('Prueba envio correo desde gmail');
        $mail->setFrom('jdyepescash@gmail@gmail.com');
        $mail->setTo('jesusyepes.1205@gmail.com');
        $mail->setBody(' Para el envio desde el gmail, en el usuario emisor hay que permitir el uso de aplicaciones no seguras: https://myaccount.google.com/lesssecureapps');
        $mail->setRead(false);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($mail);
        $dm->flush();
        return new Response('Created mailer id ' . $mail->getId());
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into createAction  " . $e, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Updates the read field, to indicates if it is send or no
     * @param $id
     * @param $value
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function updateReadFieldAction($id, $value)
    {
        $this->setLogger();
        try {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $mail = $dm->getRepository('AppBundle:Mail')->find($id);

            if (!$mail) {
                throw $this->createNotFoundException('No mail found for id ' . $id);
            }
            $mail->setRead($value);
            $dm->flush();
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into updateReadFieldAction  " . $e, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Rest\Get("/obtener/")
     * @return View|null|object
     * @throws \Exception
     */
    public function readDBMongo()
    {
        $this->setLogger();
        try {
            $content = $this->get('doctrine_mongodb')
                ->getRepository('AppBundle:Mail')
                ->findAll();
            if (!$content) {
                throw $this->createNotFoundException('No records found.');
            }
            return $content;
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into readDBmongo " . $e, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * e.g.: http://localhost:8000/cursor
     * @Rest\Get("/cursor/")
     * @return View|null|object
     * @throws \Exception
     */
    public function readCursor()
    {
        $this->setLogger();
        try {
            $content = $this->readDBMongo();
            $mes = null;
            $id = null;
            if($content!=null){
                foreach ($content as $item) {
                    $id=$item->getId();
                    $smtp = (string)$item->getSmtp();
                    $port = 587;
                    $usuario = (string)$item->getUsuario();
                    $clave = (string)$item->getClave();
                    $encry = 'tls';
                    $asunto = (string)$item->getAsunto();
                    $from = (string)$item->getUsuario();
                    $To = (string)$item->getTo();
                    $body = (string)$item->getBody();
                    $leido= $item->getRead();
                    if ($leido ===false) {
                        $this->sendMail($smtp, $port, $usuario, $clave, $encry, $asunto, $from, $To, $body);
                        $this->updateReadFieldAction($id,true);
                        $mes = ' Se enviaron los correos ';
                    } else {
                        $mes = ' Ya los correos fueron leidos y enviados ';
                    }
                }
                return $mes;
            }
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into readCursor " . $e, Response::HTTP_NOT_FOUND);
        }

    }

    /**
     * This function to send gmail with 587 port and encription tls
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
     * @throws \Exception
     */
    public function sendMail($smtp, $port, $userName, $userPasswd, $encryption, $subject, $from, $to, $body)
    {
        $this->setLogger();
        try{
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
                return new Response(' Se envio el email');

        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into sendMail " . $e, Response::HTTP_NOT_FOUND);
        }
    }
}