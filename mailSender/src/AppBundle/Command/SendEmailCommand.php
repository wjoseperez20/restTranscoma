<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 19/09/18
 * Time: 19:55
 */

namespace AppBundle\Command;

use AppBundle\Factory\CommandFactory;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;

/* Factory import*/
use AppBundle\Factory\LoggerFactory;
use AppBundle\Factory\HandleFileFactory;

class SendEmailCommand extends ContainerAwareCommand
{
    const CLASS_NAME = SendEmailCommand::class;

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
     * To set or initialize the field for logging the logs
     * @throws \Exception
     */
    public function setLogger()
    {
        try
        {
            $handle_file =HandleFileFactory::getReadFileYml();
            $this->log_directory = $handle_file->getColumn('log_directory_command');
            $this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
            $this->handler = LoggerFactory::getStreamHandler($this->log_directory);
            $this->logger->pushHandler($this->handler);
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }
    }
    protected function configure()
    {
        $this
            ->setName('send:email')
            ->setDescription('Sends email from mongoDB');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setLogger();
        $this->logger->info('This process was started in ' . SendEmailCommand::class);
        $this->readCursor();
    }


    public function readCursor()
    {
        try {
            $this->setLogger();
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
            SendEmailCommand");
            throw $e;
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
     * @Rest\Route("send")
     * @return string
     * @throws \Exception
     */
    public function sendMail($smtp, $port, $userName, $userPasswd, $encryption, $subject, $from, $to, $body)
    {
        $this->setLogger();
        $message=null;
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
            return $message= ' mail send';

        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            SendEmailCommand");
            throw $e;
        }
    }
/***************************************** Pendiente por separar*/
    public function updateReadFieldAction($id, $value)
    {
        try {
            $this->setLogger();
            $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
            $mail = $dm->getRepository('AppBundle:Mail')->find($id);

            if (!$mail) {
                return 'No mail found for id ' . $id;
            }
            $mail->setRead($value);
            $dm->flush();
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()}");
            throw $e;
        }
    }

    public function readDBMongo()
    {

        try {
            $this->setLogger();
            $content = $this->getContainer()->get('doctrine_mongodb')->getManager()
                ->getRepository('AppBundle:Mail')
                ->findAll();
            if (!$content) {
                return('No records found.');
            }
            return $content;
        }
        catch (\Exception $e)
        {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into 
            MongoDBController");
            throw $e;
        }
    }
}