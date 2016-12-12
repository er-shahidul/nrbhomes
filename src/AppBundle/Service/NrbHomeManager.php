<?php
namespace AppBundle\Service;

use AppBundle\Entity\DagNumber;
use AppBundle\Entity\Mouza;
use AppBundle\Entity\PurchasedLand;
use AppBundle\Entity\PurchasedLandRelation;
use Doctrine\ORM\EntityManager;

class NrbHomeManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createPurchasedLand($purchasedLand){

        $this->em->persist($purchasedLand);
        $this->em->flush();
    }

    public function createMouza($mouza){

        $this->em->persist($mouza);

        $this->em->flush();

    }

    public function createDagNumber($dagNumber){

        $this->em->persist($dagNumber);

        $this->em->flush();

        return $dagNumber->getId();

    }
}