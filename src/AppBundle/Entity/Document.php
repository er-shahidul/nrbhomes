<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 */
class Document
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PurchasedLand", inversedBy="documents")
     * @ORM\JoinColumn(name="purchased_land_id", referencedColumnName="id")
     */
    private $purchasedLand;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_data", type="string", length=150 , nullable=true)
     */
    private $metaData;

    /**
     * @var string
     *
     * @ORM\Column(name="attachment", type="string", length=150 , nullable=true)
     */
    private $attachment;

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
     * @return string
     */
    public function getMetaData()
    {
        return $this->metaData;
    }

    /**
     * @param string $metaData
     */
    public function setMetaData($metaData)
    {
        $this->metaData = $metaData;
    }

    /**
     * @return string
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @param string $attachment
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;
    }

    public  function getUploadDir()
    {
        return 'uploads';
    }
}
