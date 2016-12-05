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

        $newArr = array();

        $arr = $purchasedLand->getPurchasedLandRelation();
        foreach ($arr as $a) {

            if (!empty($a->getNewDagNumber())) {
                $newArr[] = array(
                    'mouza' => $a->getMouza(),
                    'newDagNumber' => $a->getNewDagNumber(),
                );
            }

        }

        $this->em->persist($purchasedLand);
        $this->em->flush();

        foreach ($newArr as $r) {
            $newDagNo = new DagNumber();
            $newDagNo->setMouza($r['mouza']);
            $newDagNo->setDagNumber($r['NewDagNumber']);
            $newDagNo->setApproved(true);
            $this->em->persist($newDagNo);
            $r['NewDagNumberObj'] = $newDagNo;
        }

        $purchasedLand->getDagNumberRelation();
    }

    public function createMouza($mouza){

        $this->em->persist($mouza);

        $this->em->flush();

    }
}