<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mouza
 *
 * @ORM\Table(name="mouzas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MouzaRepository")
 */
class Mouza
{

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Upozila")
     * @ORM\JoinColumn(name="upozila_id", referencedColumnName="id")
     */
    private $upozila;

    /**
     * @var DagNumber[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DagNumber", mappedBy="mouza")
     */
    private $dagNumbers;

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="bbs_geocode", type="string", length=2, nullable=true)
     */
    private $bbsGeocode;

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

    public function __toString()
    {
        return $this->getName();
    }

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
    public function getUpozila()
    {
        return $this->upozila;
    }

    /**
     * @param mixed $upozila
     */
    public function setUpozila($upozila)
    {
        $this->upozila = $upozila;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return DagNumber[]
     */
    public function getDagNumbers()
    {
        return $this->dagNumbers;
    }

    /**
     * @param DagNumber[] $dagNumbers
     */
    public function setDagNumbers($dagNumbers)
    {
        $this->dagNumbers = $dagNumbers;
    }



    /**
     * @return string
     */
    public function getBbsGeocode()
    {
        return $this->bbsGeocode;
    }

    /**
     * @param string $bbsGeocode
     */
    public function setBbsGeocode($bbsGeocode)
    {
        $this->bbsGeocode = $bbsGeocode;
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
