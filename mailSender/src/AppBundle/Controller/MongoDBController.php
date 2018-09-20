<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 10/08/18
 * Time: 21:39
 */

namespace AppBundle\Controller;

use AppBundle\Document\Mail;
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
    private $handle_file;

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
        try {
            $this->handle_file = HandleFileFactory::getReadFileYml();
            $this->log_directory = $this->handle_file->getColumn('log_directory_controller');
            $this->handler = LoggerFactory::getStreamHandler($this->log_directory);
            $this->logger->pushHandler($this->handler);
        } catch (\Exception $e) {
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
        try {
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
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            return new Response("Was a exception into createAction  " . $e, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Updates the read field, to indicates if it is sent or no. Its called from send:email command
     * @param $id
     * @param $value
     * @param $dm
     * @return string
     * @throws \Exception
     */
    public function updateReadFieldAction($id, $value, $dm)
    {
        $this->setLogger();
        $message = null;
        try {
            $mail = $dm->getRepository('AppBundle:Mail')->find($id);

            if (!$mail) {
                throw $this->createNotFoundException('No mail found for id ' . $id);
            }
            $mail->setRead($value);
            $dm->flush();
            return 'the mails were updated';
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            throw $e;
        }
    }

    /**
     * this function reads only the collections that are not reads from mongoDB, then to send the mails that only are not read.
     * Its called from send:email command
     * @return array
     * @throws \Exception
     * @param $dm
     */
    public function readDBMongo($dm)
    {
        $this->setLogger();
        try {
            $repository = $dm
                ->getRepository('AppBundle:Mail');
            $content = $repository->findBy(
                array('read'=>false)
            );
            if (!$content) {
                throw $this->createNotFoundException('No records found.');
            }
            return $content;
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            throw $e;
        }
    }
}