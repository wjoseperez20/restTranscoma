<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 19/09/18
 * Time: 19:55
 */

namespace AppBundle\Command;

use AppBundle\Controller\MongoDBController;
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
        try {
            $handle_file = HandleFileFactory::getReadFileYml();
            $this->log_directory = $handle_file->getColumn('log_directory_command');
            $this->logger = LoggerFactory::getLogger(self::CLASS_NAME);
            $this->handler = LoggerFactory::getStreamHandler($this->log_directory);
            $this->logger->pushHandler($this->handler);
        } catch (\Exception $e) {
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
        $message = $this->readEmailQueue();
        $output->writeln($message);
    }

    /**
     * this function reads all collections from mongo db, and updates the read field once it has been sent
     * Note: To send gmail emails, there must be the configuration set below with the default values (port and encryption")
     * @return null|string
     * @throws \Exception
     */
    public function readEmailQueue()
    {
        try {
            $obj = new MongoDBController();
            $this->setLogger();
            $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
            $content = $obj->readDBMongo($dm);
            $mes = null;
            $id = null;
            $start_time = microtime(true); //true is in seconds
            $end_time = null;
            $cont = count($content);
            $contRead = 0;
            if ($content != null) {
                foreach ($content as $item) {
                    $id = $item->getId();
                    $smtp = (string)$item->getSmtp();
                    $port = 587;
                    $usuario = (string)$item->getUsuario();
                    $clave = (string)$item->getClave();
                    $encry = 'tls';
                    $asunto = (string)$item->getAsunto();
                    $from = (string)$item->getUsuario();
                    $To = (string)$item->getTo();
                    $body = (string)$item->getBody();
                    $leido = $item->getRead();
                    if ($leido === false) {
                        $contRead++;
                        $this->sendMail($smtp, $port, $usuario, $clave, $encry, $asunto, $from, $To, $body);
                        $obj->updateReadFieldAction($id, true, $dm);
                        $mes = ' The ' . $contRead . ' mails were sent ';
                    } else {
                        $mes = ' The ' . $cont . ' mails were read and sent ';
                    }
                }
                $end_time = microtime(true);
                $elapsed_time = ($end_time - $start_time) / 60;
                $this->logger->info('Inside the ' . self::CLASS_NAME . ' Class, the status of the mail is: ' . $mes . 'It is last: ' . $elapsed_time . ' min.');
                return $mes;
            } else {
                $end_time = microtime(true);
                $elapsed_time = ($end_time - $start_time) / 60;
                $mes = 'No records found from mongoDB. The mails were read and sent. It is last ' . $elapsed_time . ' min';
                $this->logger->info($mes);
                return $mes;
            }
        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into SendEmailCommand");
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
        $message = null;
        try {
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
            return $message = ' mail send';

        } catch (\Exception $e) {
            $this->logger->error("({$e->getCode()}) Message: '{$e->getMessage()}' in file: '{$e->getFile()}' in line: {$e->getLine()} into SendEmailCommand");
            throw $e;
        }
    }
}