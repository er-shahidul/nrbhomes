<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlotRecord
 *
 * @ORM\Entity
 * @ORM\Table(name="plot_records")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlotRecordRepository")
 * @ORM\HasLifecycleCallbacks
 */
class PlotRecord
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PlotRecordRelation", mappedBy="plotRecord", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $plotRecordRelation;

    /**
     * @var string
     *
     * @ORM\Column(name="plot_name", type="string", length=150 , nullable=true)
     */
    private $plotName;

    /**
     * @var string
     *
     * @ORM\Column(name="plot_number", type="string", length=150 , nullable=true)
     */
    private $plotNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;
    /**
     * @var float
     *
     * @ORM\Column(name="total_plot_area", type="float", nullable=true)
     */
    private $totalPlotArea;


    public function __construct() {
        $this->plotRecordRelation = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPlotRecordRelation()
    {
        return $this->plotRecordRelation;
    }

    public function addPlotRecordRelation(PlotRecordRelation $plotRecordRelation) {

        if (!$this->plotRecordRelation->contains($plotRecordRelation)) {
            $this->plotRecordRelation->add($plotRecordRelation);
            $plotRecordRelation->setPlotRecord($this);
        }
    }

    public function removePlotRecordRelation(PlotRecordRelation $plotRecordRelation)
    {
        if ($this->plotRecordRelation->contains($plotRecordRelation)) {
            $this->plotRecordRelation->removeElement($plotRecordRelation);
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
     * Set address
     *
     * @param string $address
     *
     * @return PlotRecord
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
    public function getPlotName()
    {
        return $this->plotName;
    }

    /**
     * @param string $plotName
     */
    public function setPlotName($plotName)
    {
        $this->plotName = $plotName;
    }

    /**
     * @return string
     */
    public function getPlotNumber()
    {
        return $this->plotNumber;
    }

    /**
     * @param string $plotNumber
     */
    public function setPlotNumber($plotNumber)
    {
        $this->plotNumber = $plotNumber;
    }

    /**
     * @return float
     */
    public function getTotalPlotArea()
    {
        return $this->totalPlotArea;
    }

    /**
     * @param float $totalPlotArea
     */
    public function setTotalPlotArea($totalPlotArea)
    {
        $this->totalPlotArea = $totalPlotArea;
    }

}

