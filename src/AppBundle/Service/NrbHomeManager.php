<?php
namespace AppBundle\Service;

use AppBundle\Entity\DagNumber;
use AppBundle\Entity\Document;
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

    public function createPurchasedLand($purchasedLand, $formData){

        //var_dump($formData);die;
        $this->em->persist($purchasedLand);

        if(isset($formData['files']['doc_file'])){

            $files = $formData['files']['doc_file'];
            $meta_data = $formData['meta_data'];
            foreach($files as $key=>$img){
                $documents = new Document();
                $fileName = $img->getClientOriginalName();
                $img->move($documents->getUploadDir(), $fileName);
                $documents->setPurchasedLand($purchasedLand);
                $documents->setAttachment($fileName);
                $documents->setMetaData($meta_data[$key]);
                $this->em->persist($documents);
            }
        }
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



    public function createPlotRecord($plotRecord){

        //var_dump($formData);die;
        $this->em->persist($plotRecord);

        $this->em->flush();
    }
}