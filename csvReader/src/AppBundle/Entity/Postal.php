<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postal
 *
 * @ORM\Table(name="postal")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostalRepository")
 */
class Postal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="trackingNumber", type="string", length=255)
     */
    private $trackingNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="conocimientoAereo", type="string", length=255)
     */
    private $conocimientoAereo;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="bagLabel", type="string", length=255)
     */
    private $bagLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255)
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=255)
     */
    private $destination;

    /**
     * @var string
     *
     * @ORM\Column(name="sumaria", type="string", length=255)
     */
    private $sumaria;

    /**
     * @var int
     *
     * @ORM\Column(name="partida", type="integer")
     */
    private $partida;

    /**
     * @var string
     *
     * @ORM\Column(name="internalAccountNumber", type="string", length=255)
     */
    private $internalAccountNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="shipperName", type="string", length=255)
     */
    private $shipperName;

    /**
     * @var string
     *
     * @ORM\Column(name="shipAdd1", type="string", length=255)
     */
    private $shipAdd1;

    /**
     * @var string
     *
     * @ORM\Column(name="shipAdd2", type="string", length=255)
     */
    private $shipAdd2;

    /**
     * @var string
     *
     * @ORM\Column(name="shipAdd3", type="string", length=255)
     */
    private $shipAdd3;

    /**
     * @var string
     *
     * @ORM\Column(name="shipCity", type="string", length=255, nullable=true)
     */
    private $shipCity;

    /**
     * @var string
     *
     * @ORM\Column(name="shipState", type="string", length=255,nullable=true)
     */
    private $shipState;

    /**
     * @var int
     *
     * @ORM\Column(name="shipZip", type="integer",nullable=true)
     */
    private $shipZip;

    /**
     * @var string
     *
     * @ORM\Column(name="shipCountryCode", type="string", length=255)
     */
    private $shipCountryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="nif", type="string", length=255)
     */
    private $nif;

    /**
     * @var string
     *
     * @ORM\Column(name="consignee", type="string", length=255)
     */
    private $consignee;

    /**
     * @var string
     *
     * @ORM\Column(name="address1", type="string", length=255)
     */
    private $address1;

    /**
     * @var string
     *
     * @ORM\Column(name="address2", type="string", length=255)
     */
    private $address2;

    /**
     * @var string
     *
     * @ORM\Column(name="address3", type="string", length=255)
     */
    private $address3;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=255)
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="zip", type="integer")
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="countryCode", type="string", length=255)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var int
     *
     * @ORM\Column(name="pieces", type="integer")
     */
    private $pieces;

    /**
     * @var float
     *
     * @ORM\Column(name="totalWeight", type="float")
     */
    private $totalWeight;

    /**
     * @var string
     *
     * @ORM\Column(name="weightUOM", type="string")
     */
    private $weightUOM;

    // @ORM\Column(name="totalValue", type="float", scale=2)
    /**
     * @var float
     *
     * @ORM\Column(name="totalValue", type="string", length=10)
     */
    private $totalValue;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;

    /**
     * @var string
     *
     * @ORM\Column(name="incoterms", type="string")
     */
    private $incoterms;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string")
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="itemDescription", type="string")
     */
    private $itemDescription;

    /**
     * @var int
     *
     * @ORM\Column(name="itemHsCode", type="bigint")
     */
    private $itemHsCode;

    /**
     * @var int
     *
     * @ORM\Column(name="itemQuantity", type="integer")
     */
    private $itemQuantity;

    /**
     * @var float
     *
     * @ORM\Column(name="itemValue", type="float")
     */
    private $itemValue;

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
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * @param $trackingNumber
     * @return $this
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;

        return $this;

    }

    /**
     * @return string
     */
    public function getConocimientoAereo()
    {
        return $this->conocimientoAereo;
    }

    /**
     * @param $conocimientoAereo
     * @return $this
     */
    public function setConocimientoAereo($conocimientoAereo)
    {
        $this->conocimientoAereo = $conocimientoAereo;

        return $this;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getBagLabel()
    {
        return $this->bagLabel;
    }

    /**
     * @param $bagLabel
     * @return $this
     */
    public function setBagLabel($bagLabel)
    {
        $this->bagLabel = $bagLabel;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * @param $origin
     * @return $this
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param $destination
     * @return $this
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * @return int
     */
    public function getSumaria()
    {
        return $this->sumaria;
    }

    /**
     * @param $sumaria
     * @return $this
     */
    public function setSumaria($sumaria)
    {
        $this->sumaria = $sumaria;

        return $this;
    }

    /**
     * @return int
     */
    public function getPartida()
    {
        return $this->partida;
    }

    /**
     * @param $partida
     * @return $this
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * @return int
     */
    public function getInternalAccountNumber()
    {
        return $this->internalAccountNumber;
    }

    /**
     * @param $internalAccountNumber
     * @return $this
     */
    public function setInternalAccountNumber($internalAccountNumber)
    {
        $this->internalAccountNumber = $internalAccountNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipperName()
    {
        return $this->shipperName;
    }

    /**
     * @param $shipperName
     * @return $this
     */
    public function setShipperName($shipperName)
    {
        $this->shipperName = $shipperName;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipAdd1()
    {
        return $this->shipAdd1;
    }

    /**
     * @param $shipAdd1
     * @return $this
     */
    public function setShipAdd1($shipAdd1)
    {
        $this->shipAdd1 = $shipAdd1;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipAdd2()
    {
        return $this->shipAdd2;
    }

    /**
     * @param $shipAdd2
     * @return $this
     */
    public function setShipAdd2($shipAdd2)
    {
        $this->shipAdd2 = $shipAdd2;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipAdd3()
    {
        return $this->shipAdd3;
    }

    /**
     * @param $shipAdd3
     * @return $this
     */
    public function setShipAdd3($shipAdd3)
    {
        $this->shipAdd3 = $shipAdd3;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * @param $shipCity
     * @return $this
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipState()
    {
        return $this->shipState;
    }

    /**
     * @param $shipState
     * @return $this
     */
    public function setShipState($shipState)
    {
        $this->shipState = $shipState;

        return $this;
    }

    /**
     * @return int
     */
    public function getShipZip()
    {
        return $this->shipZip;
    }

    /**
     * @param $shipZip
     * @return $this
     */
    public function setShipZip($shipZip)
    {
        $this->shipZip = $shipZip;

        return $this;
    }

    /**
     * @return string
     */
    public function getShipCountryCode()
    {
        return $this->shipCountryCode;
    }

    /**
     * @param $shipCountryCode
     * @return $this
     */
    public function setShipCountryCode($shipCountryCode)
    {
        $this->shipCountryCode = $shipCountryCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * @param $nif
     * @return $this
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * @return string
     */
    public function getConsignee()
    {
        return $this->consignee;
    }

    /**
     * @param $consignee
     * @return $this
     */
    public function setConsignee($consignee)
    {
        $this->consignee = $consignee;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param $address1
     * @return $this
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param $address2
     * @return $this
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * @param $address3
     * @return $this
     */
    public function setAddress3($address3)
    {
        $this->address3 = $address3;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param $state
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return int
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param $zip
     * @return $this
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param $countryCode
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return int
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * @param $pieces
     * @return $this
     */
    public function setPieces($pieces)
    {
        $this->pieces = $pieces;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
    }

    /**
     * @param $totalWeight
     * @return $this
     */
    public function setTotalWeight($totalWeight)
    {
        $this->totalWeight = $totalWeight;

        return $this;
    }

    /**
     * @return string
     */
    public function getWeightUOM()
    {
        return $this->weightUOM;
    }

    /**
     * @param $weightUOM
     * @return $this
     */
    public function setWeightUOM($weightUOM)
    {
        $this->weightUOM = $weightUOM;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * @param $totalValue
     * @return $this
     */
    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getIncoterms()
    {
        return $this->incoterms;
    }

    /**
     * @param $incoterms
     * @return $this
     */
    public function setIncoterms($incoterms)
    {
        $this->incoterms = $incoterms;

        return $this;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param $service
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return string
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * @param $itemDescription
     * @return $this
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemHsCode()
    {
        return $this->itemHsCode;
    }

    /**
     * @param $itemHsCode
     * @return $this
     */
    public function setItemHsCode($itemHsCode)
    {
        $this->itemHsCode = $itemHsCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @param $itemQuantity
     * @return $this
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->itemQuantity = $itemQuantity;

        return $this;
    }

    /**
     * @return float
     */
    public function getItemValue()
    {
        return $this->itemValue;
    }

    /**
     * @param $itemValue
     * @return $this
     */
    public function setItemValue($itemValue)
    {
        $this->itemValue = $itemValue;

        return $this;
    }

}
