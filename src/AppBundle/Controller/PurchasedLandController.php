<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PurchasedLand;
use AppBundle\Entity\PurchasedLandRelation;
use AppBundle\Form\PurchasedLandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PurchasedLandController extends Controller
{
    public function indexAction()
    {

    }

    public function createPurchasedLandAction(Request $request )
    {

        $purchasedLand = new PurchasedLand();
        //var_dump('ok');die;
        $form = $this->createForm(PurchasedLandType::class, $purchasedLand);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->get('app_bundle.service.nrbhome_manager')->createPurchasedLand($purchasedLand);

            }
        }
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('purchased_land_add');
        return $this->render('AppBundle:Purchasedland:add.html.twig',$data);

    }
}