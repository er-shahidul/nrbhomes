<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mouza;
use AppBundle\Entity\PurchasedLandRelation;
use AppBundle\Form\MouzaType;
use AppBundle\Form\PurchasedLandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MouzaController extends Controller
{

    public function createMouzaAction(Request $request )
    {

        $mouza = new Mouza();
        $form = $this->createForm(MouzaType::class, $mouza);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->get('app_bundle.service.nrbhome_manager')->createMouza($mouza);

                return new Response('SUCCESS');
            }
        }
        $data['form'] = $form->createView();
        return $this->render('AppBundle:Mouza:add-mouza.html.twig',$data);

    }

}