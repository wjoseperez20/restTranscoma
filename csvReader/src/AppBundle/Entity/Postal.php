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
     * @var int
     *
     * @ORM\Column(name="reference", type="integer")
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
     * @var int
     *
     * @ORM\Column(name="sumaria", type="integer")
     */
    private $sumaria;

    /**
     * @var int
     *
     * @ORM\Column(name="partida", type="integer")
     */
    private $partida;

    /**
     * @var int
     *
     * @ORM\Column(name="internalAccountNumber", type="integer")
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
     * @ORM\Column(name="shipCity", type="string", length=255)
     */
    private $shipCity;

    /**
     * @var string
     *
     * @ORM\Column(name="shipState", type="string", length=255)
     */
    private $shipState;

    /**
     * @var int
     *
     * @ORM\Column(name="shipZip", type="integer")
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

    /**
     * @var float
     *
     * @ORM\Column(name="totalValue", type="float")
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
     * @ORM\Column(name="itemHsCore", type="integer")
     */
    private $itemHsCore;

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

    /** -------------------------------getters y setters------------------- */

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set trackingNumber.
     *
     * @param string $trackingNumber
     *
     * @return Postal
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->trackingNumber = $trackingNumber;

        return $this;
    }

    /**
     * Get trackingNumber.
     *
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->trackingNumber;
    }

    /**
     * Set conocimientoAereo.
     *
     * @param string $conocimientoAereo
     *
     * @return Postal
     */
    public function setConocimientoAereo($conocimientoAereo)
    {
        $this->conocimientoAereo = $conocimientoAereo;

        return $this;
    }

    /**
     * Get conocimientoAereo.
     *
     * @return string
     */
    public function getConocimientoAereo()
    {
        return $this->conocimientoAereo;
    }

    /**
     * Set reference.
     *
     * @param int $reference
     *
     * @return Postal
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference.
     *
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set bagLabel.
     *
     * @param string $bagLabel
     *
     * @return Postal
     */
    public function setBagLabel($bagLabel)
    {
        $this->bagLabel = $bagLabel;

        return $this;
    }

    /**
     * Get bagLabel.
     *
     * @return string
     */
    public function getBagLabel()
    {
        return $this->bagLabel;
    }

    /**
     * Set origin.
     *
     * @param string $origin
     *
     * @return Postal
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin.
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set destination.
     *
     * @param string $destination
     *
     * @return Postal
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination.
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set sumaria.
     *
     * @param int $sumaria
     *
     * @return Postal
     */
    public function setSumaria($sumaria)
    {
        $this->sumaria = $sumaria;

        return $this;
    }

    /**
     * Get sumaria.
     *
     * @return int
     */
    public function getSumaria()
    {
        return $this->sumaria;
    }

    /**
     * Set partida.
     *
     * @param int $partida
     *
     * @return Postal
     */
    public function setPartida($partida)
    {
        $this->partida = $partida;

        return $this;
    }

    /**
     * Get partida.
     *
     * @return int
     */
    public function getPartida()
    {
        return $this->partida;
    }

    /**
     * Set internalAccountNumber.
     *
     * @param int $internalAccountNumber
     *
     * @return Postal
     */
    public function setInternalAccountNumber($internalAccountNumber)
    {
        $this->internalAccountNumber = $internalAccountNumber;

        return $this;
    }

    /**
     * Get internalAccountNumber.
     *
     * @return int
     */
    public function getInternalAccountNumber()
    {
        return $this->internalAccountNumber;
    }

    /**
     * Set shipperName.
     *
     * @param string $shipperName
     *
     * @return Postal
     */
    public function setShipperName($shipperName)
    {
        $this->shipperName = $shipperName;

        return $this;
    }

    /**
     * Get shipperName.
     *
     * @return string
     */
    public function getShipperName()
    {
        return $this->shipperName;
    }

    /**
     * Set shipAdd1.
     *
     * @param string $shipAdd1
     *
     * @return Postal
     */
    public function setShipAdd1($shipAdd1)
    {
        $this->shipAdd1 = $shipAdd1;

        return $this;
    }

    /**
     * Get shipAdd1.
     *
     * @return string
     */
    public function getShipAdd1()
    {
        return $this->shipAdd1;
    }

    /**
     * Set shipAdd2.
     *
     * @param string $shipAdd2
     *
     * @return Postal
     */
    public function setShipAdd2($shipAdd2)
    {
        $this->shipAdd2 = $shipAdd2;

        return $this;
    }

    /**
     * Get shipAdd2.
     *
     * @return string
     */
    public function getShipAdd2()
    {
        return $this->shipAdd2;
    }

    /**
     * Set shipAdd3.
     *
     * @param string $shipAdd3
     *
     * @return Postal
     */
    public function setShipAdd3($shipAdd3)
    {
        $this->shipAdd3 = $shipAdd3;

        return $this;
    }

    /**
     * Get shipAdd3.
     *
     * @return string
     */
    public function getShipAdd3()
    {
        return $this->shipAdd3;
    }

    /**
     * Set shipCity.
     *
     * @param string $shipCity
     *
     * @return Postal
     */
    public function setShipCity($shipCity)
    {
        $this->shipCity = $shipCity;

        return $this;
    }

    /**
     * Get shipCity.
     *
     * @return string
     */
    public function getShipCity()
    {
        return $this->shipCity;
    }

    /**
     * Set shipState.
     *
     * @param string $shipState
     *
     * @return Postal
     */
    public function setShipState($shipState)
    {
        $this->shipState = $shipState;

        return $this;
    }

    /**
     * Get shipState.
     *
     * @return string
     */
    public function getShipState()
    {
        return $this->shipState;
    }

    /**
     * Set shipZip.
     *
     * @param int $shipZip
     *
     * @return Postal
     */
    public function setShipZip($shipZip)
    {
        $this->shipZip = $shipZip;

        return $this;
    }

    /**
     * Get shipZip.
     *
     * @return int
     */
    public function getShipZip()
    {
        return $this->shipZip;
    }

    /**
     * Set shipCountryCode.
     *
     * @param string $shipCountryCode
     *
     * @return Postal
     */
    public function setShipCountryCode($shipCountryCode)
    {
        $this->shipCountryCode = $shipCountryCode;

        return $this;
    }

    /**
     * Get shipCountryCode.
     *
     * @return string
     */
    public function getShipCountryCode()
    {
        return $this->shipCountryCode;
    }

    /**
     * Set nif.
     *
     * @param string $nif
     *
     * @return Postal
     */
    public function setNif($nif)
    {
        $this->nif = $nif;

        return $this;
    }

    /**
     * Get nif.
     *
     * @return string
     */
    public function getNif()
    {
        return $this->nif;
    }

    /**
     * Set consignee.
     *
     * @param string $consignee
     *
     * @return Postal
     */
    public function setConsignee($consignee)
    {
        $this->consignee = $consignee;

        return $this;
    }

    /**
     * Get consignee.
     *
     * @return string
     */
    public function getConsignee()
    {
        return $this->consignee;
    }

    /**
     * Set address1.
     *
     * @param string $address1
     *
     * @return Postal
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1.
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2.
     *
     * @param string $address2
     *
     * @return Postal
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2.
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set address3.
     *
     * @param string $address3
     *
     * @return Postal
     */
    public function setAddress3($address3)
    {
        $this->address3 = $address3;

        return $this;
    }

    /**
     * Get address3.
     *
     * @return string
     */
    public function getAddress3()
    {
        return $this->address3;
    }

    /**
     * Set city.
     *
     * @param string $city
     *
     * @return Postal
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state.
     *
     * @param string $state
     *
     * @return Postal
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip.
     *
     * @param int $zip
     *
     * @return Postal
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip.
     *
     * @return int
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set countryCode.
     *
     * @param string $countryCode
     *
     * @return Postal
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode.
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Postal
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return Postal
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set pieces.
     *
     * @param int $pieces
     *
     * @return Postal
     */
    public function setPieces($pieces)
    {
        $this->pieces = $pieces;

        return $this;
    }

    /**
     * Get pieces.
     *
     * @return int
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * Set totalWeight.
     *
     * @param float $totalWeight
     *
     * @return Postal
     */
    public function setTotalWeight($totalWeight)
    {
        $this->totalWeight = $totalWeight;

        return $this;
    }

    /**
     * Get totalWeight.
     *
     * @return float
     */
    public function getTotalWeight()
    {
        return $this->totalWeight;
    }

    /**
     * @return string
     */
    public function getWeightUOM()
    {
        return $this->weightUOM;
    }

    /**
     * @param string $weightUOM
     */
    public function setWeightUOM($weightUOM)
    {
        $this->weightUOM = $weightUOM;
    }

    /**
     * @return float
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * @param float $totalValue
     */
    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getIncoterms()
    {
        return $this->incoterms;
    }

    /**
     * @param string $incoterms
     */
    public function setIncoterms($incoterms)
    {
        $this->incoterms = $incoterms;
    }

    /**
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    /**
     * @param string $itemDescription
     */
    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }

    /**
     * @return int
     */
    public function getItemHsCore()
    {
        return $this->itemHsCore;
    }

    /**
     * @param int $itemHsCore
     */
    public function setItemHsCore($itemHsCore)
    {
        $this->itemHsCore = $itemHsCore;
    }

    /**
     * @return int
     */
    public function getItemQuantity()
    {
        return $this->itemQuantity;
    }

    /**
     * @param int $itemQuantity
     */
    public function setItemQuantity($itemQuantity)
    {
        $this->itemQuantity = $itemQuantity;
    }

    /**
     * @return float
     */
    public function getItemValue()
    {
        return $this->itemValue;
    }

    /**
     * @param float $itemValue
     */
    public function setItemValue($itemValue)
    {
        $this->itemValue = $itemValue;
    }


}
