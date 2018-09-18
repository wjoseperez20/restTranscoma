<?php
/**
 * Created by PhpStorm.
 * User: maggie
 * Date: 17/09/18
 * Time: 19:56
 */

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Mail
 * @package AppBundle\Document
 * @MongoDB\Document
 */
class Mail
{
    /**
     *
     * @MongoDB\Id
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $smtp;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $usuario;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $clave;
    /**
     * @MongoDB\Field(type="string")
     */
    protected $asunto;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $from;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $to;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $body;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $read;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getSmtp()
    {
        return $this->smtp;
    }

    /**
     * @param mixed $smtp
     * @return Mail
     */
    public function setSmtp($smtp)
    {
        $this->smtp = $smtp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     * @return Mail
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * @param mixed $clave
     * @return Mail
     */
    public function setClave($clave)
    {
        $this->clave = $clave;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAsunto()
    {
        return $this->asunto;
    }

    /**
     * @param mixed $asunto
     * @return Mail
     */
    public function setAsunto($asunto)
    {
        $this->asunto = $asunto;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     * @return Mail
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     * @return Mail
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return Mail
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * @param mixed $read
     * @return Mail
     */
    public function setRead($read)
    {
        $this->read = $read;
        return $this;
    }

}