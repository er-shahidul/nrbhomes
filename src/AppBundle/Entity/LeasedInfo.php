<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * LeasedInfo
 *
 * @ORM\Entity
 * @ORM\Table(name="leased_info")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LeasedInfoRepository")
 * @ORM\HasLifecycleCallbacks
 */
class LeasedInfo
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
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\PurchasedLand", inversedBy="leasedInfo")
     * @ORM\JoinColumn(name="purchased_land_id", referencedColumnName="id")
     */
    private $purchasedLand;

    /**
     * @var string
     *
     * @ORM\Column(name="deed_number", type="string", length=150 , nullable=true)
     */
    private $deedNumber;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deed_date", type="date", nullable=true)
     */
    private $deedDate;

    /**
     * @var string
     *
     * @ORM\Column(name="deed_duration", type="string", length=150 , nullable=true)
     */
    private $deedDuration;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lease_start_date", type="date", nullable=true)
     */
    private $leaseStartDate;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=150 , nullable=true)
     */
    private $status;


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
     * Set status
     *
     * @param string $status
     *
     * @return LeasedInfo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurchasedLand()
    {
        return $this->purchasedLand;
    }

    /**
     * @param PurchasedLand $purchasedLand
     * @return LeasedInfo
     */
    public function setPurchasedLand(PurchasedLand $purchasedLand)
    {
        $this->purchasedLand = $purchasedLand;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeedNumber()
    {
        return $this->deedNumber;
    }

    /**
     * @param string $deedNumber
     */
    public function setDeedNumber($deedNumber)
    {
        $this->deedNumber = $deedNumber;
    }

    /**
     * @return \DateTime
     */
    public function getDeedDate()
    {
        return $this->deedDate;
    }

    /**
     * @param \DateTime $deedDate
     */
    public function setDeedDate($deedDate)
    {
        $this->deedDate = $deedDate;
    }

    /**
     * @return string
     */
    public function getDeedDuration()
    {
        return $this->deedDuration;
    }

    /**
     * @param string $deedDuration
     */
    public function setDeedDuration($deedDuration)
    {
        $this->deedDuration = $deedDuration;
    }

    /**
     * @return \DateTime
     */
    public function getLeaseStartDate()
    {
        return $this->leaseStartDate;
    }

    /**
     * @param \DateTime $leaseStartDate
     */
    public function setLeaseStartDate($leaseStartDate)
    {
        $this->leaseStartDate = $leaseStartDate;
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



}

