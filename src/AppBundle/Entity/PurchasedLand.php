<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PurchasedLand
 *
 * @ORM\Entity
 * @ORM\Table(name="purchased_lands")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchasedLandRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PurchasedLand
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchasedLandRelation", mappedBy="purchasedLand", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $purchasedLandRelation;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\LeasedInfo", mappedBy="purchasedLand", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $leasedInfo;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Document", mappedBy="purchasedLand", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $documents;


    /**
     * @var string
     *
     * @ORM\Column(name="land_owner_name", type="string", length=150 , nullable=true)
     */
    private $landOwnerName;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="total_amount", type="decimal", nullable=true)
     */
    private $totalAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="paid_amount", type="decimal", nullable=true)
     */
    private $paidAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="land_type", type="string", length=150, columnDefinition="ENUM('PRIVATE', 'DEMESNE', 'VESTED')", nullable=true)
     */
    protected $landType;

    /**
     * @var string
     *
     * @ORM\Column(name="ownership_type", type="string", length=150, columnDefinition="ENUM('HEREDITARY', 'PURCHASE', 'ALLOTMENT', 'WILL', 'ILLEGAL')", nullable=true)
     */
    protected $ownershipType;

    /**
     * @var string
     *
     * @ORM\Column(name="purchased_property", type="string", length=150, columnDefinition="ENUM('REGISTERED', 'TENDER', 'ATTORNEY')", nullable=true)
     */
    protected $purchasedProperty;

    /**
     * @var string
     *
     * @ORM\Column(name="paid_method", type="string", length=150, columnDefinition="ENUM('ONETIME', 'INSTALLMENT')", nullable=true)
     */
    protected $paidMethod;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=150 , nullable=true)
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="leased", type="boolean")
     */
    private $leased;

    /**
     * @var boolean
     *
     * @ORM\Column(name="purchased", type="boolean")
     */
    private $purchased;

    public function __construct() {
        $this->setLeased(false);
        $this->setPurchased(false);
        $this->purchasedLandRelation = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPurchasedLandRelation()
    {
        return $this->purchasedLandRelation;
    }

    public function addPurchasedLandRelation(PurchasedLandRelation $purchasedLandRelation) {

        if (!$this->purchasedLandRelation->contains($purchasedLandRelation)) {
            $this->purchasedLandRelation->add($purchasedLandRelation);
            $purchasedLandRelation->setPurchasedLand($this);
        }
    }

    public function removePurchasedLandRelation(PurchasedLandRelation $purchasedLandRelation)
    {
        if ($this->purchasedLandRelation->contains($purchasedLandRelation)) {
            $this->purchasedLandRelation->removeElement($purchasedLandRelation);
        }
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param mixed $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @return mixed
     */
    public function getLeasedInfo()
    {
        return $this->leasedInfo;
    }

    /**
     * @param mixed $leasedInfo
     * @return $this
     */
    public function setLeasedInfo($leasedInfo)
    {
        $leasedInfo->setPurchasedLand($this);
        $this->leasedInfo = $this->isLeased()?$leasedInfo:null;
        return $this;
    }

    /**
     * Set landOwnerName
     *
     * @param string $landOwnerName
     *
     * @return PurchasedLand
     */
    public function setLandOwnerName($landOwnerName)
    {
        $this->landOwnerName = $landOwnerName;

        return $this;
    }

    /**
     * Get landOwnerName
     *
     * @return string
     */
    public function getLandOwnerName()
    {
        return $this->landOwnerName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return PurchasedLand
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param string $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return string
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param string $paidAmount
     */
    public function setPaidAmount($paidAmount)
    {
        $this->paidAmount = $paidAmount;
    }


    /**
     * Set landType
     *
     * @param string $landType
     *
     * @return PurchasedLand
     */
    public function setLandType($landType)
    {
        $this->landType = $landType;

        return $this;
    }

    /**
     * Get landType
     *
     * @return string
     */
    public function getLandType()
    {
        return $this->landType;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return PurchasedLand
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return boolean
     */
    public function isLeased()
    {
        return $this->leased;
    }

    /**
     * @param boolean $leased
     */
    public function setLeased($leased)
    {
        $this->leased = $leased;
        if (!$leased) {
            $this->leasedInfo = null;
        }
    }

    /**
     * @return boolean
     */
    public function isPurchased()
    {
        return $this->purchased;
    }

    /**
     * @param boolean $purchased
     */
    public function setPurchased($purchased)
    {
        $this->purchased = $purchased;
    }

    /**
     * @return string
     */
    public function getOwnershipType()
    {
        return $this->ownershipType;
    }

    /**
     * @param string $ownershipType
     */
    public function setOwnershipType($ownershipType)
    {
        $this->ownershipType = $ownershipType;
    }

    /**
     * @return string
     */
    public function getPurchasedProperty()
    {
        return $this->purchasedProperty;
    }

    /**
     * @param string $purchasedProperty
     */
    public function setPurchasedProperty($purchasedProperty)
    {
        $this->purchasedProperty = $purchasedProperty;
    }

    /**
     * @return string
     */
    public function getPaidMethod()
    {
        return $this->paidMethod;
    }

    /**
     * @param string $paidMethod
     */
    public function setPaidMethod($paidMethod)
    {
        $this->paidMethod = $paidMethod;
    }


}

