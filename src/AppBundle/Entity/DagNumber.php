<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DagNumber
 *
 * @ORM\Table(name="dag_numbers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DagNumberRepository")
 */
class DagNumber
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mouza", inversedBy="dagNumbers")
     * @ORM\JoinColumn(name="mouza_id", referencedColumnName="id")
     */
    private $mouza;

    /**
     * @var PurchasedLandRelation[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchasedLandRelation", mappedBy="dagNumber")
     */
    private $purchasedLandRelations;

    /**
     * @var PlotRecordRelation[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PlotRecordRelation", mappedBy="dagNumber")
     */
    private $plotRecordRelations;

    /**
     * @var string
     *
     * @ORM\Column(name="dag_number_name", type="string", length=255, nullable=true)
     */
    private $dagNumberName;

    /**
     * @var float
     *
     * @ORM\Column(name="dag_total_area", type="float", nullable=true)
     */
    private $dagTotalArea;

    /**
     * @var boolean
     *
     * @ORM\Column(name="approved", type="boolean")
     */
    private $approved;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function __construct()
    {
        $this->setApproved(true);
    }
    public function __toString() {
        return $this->dagNumberName;
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
    public function getDagNumberName()
    {
        return $this->dagNumberName;
    }

    /**
     * @param string $dagNumberName
     */
    public function setDagNumberName($dagNumberName)
    {
        $this->dagNumberName = $dagNumberName;
    }

    /**
     * @return float
     */
    public function getDagTotalArea()
    {
        return $this->dagTotalArea;
    }

    /**
     * @param float $dagTotalArea
     */
    public function setDagTotalArea($dagTotalArea)
    {
        $this->dagTotalArea = $dagTotalArea;
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
     * @return PurchasedLandRelation[]
     */
    public function getPurchasedLandRelations()
    {
        return $this->purchasedLandRelations;
    }

    /**
     * @param PurchasedLandRelation[] $purchasedLandRelations
     */
    public function setPurchasedLandRelations($purchasedLandRelations)
    {
        $this->purchasedLandRelations = $purchasedLandRelations;
    }

    /**
     * @return PlotRecordRelation[]
     */
    public function getPlotRecordRelations()
    {
        return $this->plotRecordRelations;
    }

    /**
     * @param PlotRecordRelation[] $plotRecordRelations
     */
    public function setPlotRecordRelations($plotRecordRelations)
    {
        $this->plotRecordRelations = $plotRecordRelations;
    }


}
