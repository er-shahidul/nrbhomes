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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mouza")
     * @ORM\JoinColumn(name="mouza_id", referencedColumnName="id")
     */
    private $mouza;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="dag_number", type="string", length=255, nullable=true)
     */
    private $dagNumber;

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


}
