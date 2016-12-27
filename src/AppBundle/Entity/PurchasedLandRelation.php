<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchasedLandRelation
 *
 * @ORM\Table(name="purchased_land_relations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchasedLandRelationRepository")
 */
class PurchasedLandRelation
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PurchasedLand", inversedBy="purchasedLandRelation")
     * @ORM\JoinColumn(name="purchased_land_id", referencedColumnName="id")
     */
    private $purchasedLand;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mouza", inversedBy="purchasedLandRelations")
     * @ORM\JoinColumn(name="mouza_id", referencedColumnName="id")
     */
    private $mouza;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DagNumber")
     * @ORM\JoinColumn(name="dag_number_id", referencedColumnName="id")
     */
    private $dagNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="purchased_total_area", type="float", nullable=true)
     */
    private $purchasedTotalArea;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;


    public function __construct()
    {
        $this->setDeleted(false);
        $this->setApproved(true);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPurchasedLand()
    {
        return $this->purchasedLand;
    }

    /**
     * @param mixed $purchasedLand
     */
    public function setPurchasedLand($purchasedLand)
    {
        $this->purchasedLand = $purchasedLand;
    }

    /**
     * @return mixed
     */
    public function getMouza()
    {
        return $this->mouza;
    }

    /**
     * @param mixed $mouza
     */
    public function setMouza($mouza)
    {
        $this->mouza = $mouza;
    }

    /**
     * @return string
     */
    public function getDagNumber()
    {
        return $this->dagNumber;
    }

    /**
     * @param string $dagNumber
     */
    public function setDagNumber($dagNumber)
    {
        $this->dagNumber = $dagNumber;
    }

    /**
     * @return float
     */
    public function getPurchasedTotalArea()
    {
        return $this->purchasedTotalArea;
    }

    /**
     * @param float $purchasedTotalArea
     */
    public function setPurchasedTotalArea($purchasedTotalArea)
    {
        $this->purchasedTotalArea = $purchasedTotalArea;
    }

    /**
     * @return boolean
     */
    public function isApproved()
    {
        return $this->approved;
    }

    /**
     * @param boolean $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }


}
