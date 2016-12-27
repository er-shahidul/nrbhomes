<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlotRecordRelation
 *
 * @ORM\Table(name="plot_record_relations")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlotRecordRelationRepository")
 */
class PlotRecordRelation
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlotRecord", inversedBy="PlotRecordRelation")
     * @ORM\JoinColumn(name="plot_record_id", referencedColumnName="id")
     */
    private $plotRecord;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\DagNumber")
     * @ORM\JoinColumn(name="dag_number_id", referencedColumnName="id")
     */
    private $dagNumber;

    /**
     * @var float
     *
     * @ORM\Column(name="dag_area", type="float", nullable=true)
     */
    private $dagArea;

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
    public function getPlotRecord()
    {
        return $this->plotRecord;
    }

    /**
     * @param mixed $plotRecord
     */
    public function setPlotRecord($plotRecord)
    {
        $this->plotRecord = $plotRecord;
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
    public function getDagArea()
    {
        return $this->dagArea;
    }

    /**
     * @param float $dagArea
     */
    public function setDagArea($dagArea)
    {
        $this->dagArea = $dagArea;
    }

}
