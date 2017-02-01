<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\PurchasedLand;
use AppBundle\Entity\PurchasedLandRelation;
use AppBundle\Form\PurchasedLandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PurchasedLandController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $purchasedLands = $em->getRepository('AppBundle:PurchasedLand')->getPurchasedLandList($request->query->all());
        $data['landTypes']= array( 'PRIVATE' => 'Private Land', 'DEMESNE' => 'Demesne Land', 'VESTED' => 'Vested Property');
        $data['purchases']= array(1 => 'Yes', 0 => 'No');
        $data['leases']= array(1 => 'Yes', 0 => 'No');
        $paginator  = $this->get('knp_paginator');
        $data['lands'] = $paginator->paginate(
            $purchasedLands, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        if ($request->isXmlHttpRequest()) {
            return $this->render('AppBundle:Purchasedland:list_content.html.twig', $data);
        } else {
            $data['search_url'] = $this->generateUrl('purchased_land_list');
            return $this->render('AppBundle:Purchasedland:index.html.twig', $data);
        }
    }

    public function createPurchasedLandAction(Request $request )
    {

        $purchasedLand = new PurchasedLand();
        //var_dump('ok');die;
        $form = $this->createForm(PurchasedLandType::class, $purchasedLand);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $formData['meta_data'] = $request->request->get('meta_data');
                $formData['files'] = $request->files->all();
                $this->get('app_bundle.service.nrbhome_manager')->createPurchasedLand($purchasedLand, $formData);
                return $this->redirect($this->generateUrl('purchased_land_list'));
            }
        }
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('purchased_land_add');
        return $this->render('AppBundle:Purchasedland:add.html.twig',$data);

    }

    public function updatePurchasedLandAction(Request $request, PurchasedLand $purchasedLand )
    {

        //$purchasedLand = new PurchasedLand();
        $existDocument = $this->getDoctrine()->getRepository('AppBundle:Document')->findBy(array('purchasedLand'=>$purchasedLand));
        $form = $this->createForm(PurchasedLandType::class, $purchasedLand);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $formData['meta_data'] = $request->request->get('meta_data');
                $formData['files'] = $request->files->all();
                $this->get('app_bundle.service.nrbhome_manager')->createPurchasedLand($purchasedLand, $formData);
                return $this->redirect($this->generateUrl('purchased_land_list'));
            }
        }
        $data['documents'] = $existDocument;
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('purchased_land_update',array('id'=>$purchasedLand->getId()));
        return $this->render('AppBundle:Purchasedland:add.html.twig',$data);

    }


    public function documentDeleteAction(Request $request, Document $document)
    {

        if (!$this->isCsrfTokenValid('delete_document', $request->query->get('_token'))) {
            throw new AccessDeniedHttpException('Invalid token');
        }

        $this->getDoctrine()->getRepository('AppBundle:Document')->delete($document);

        return new JsonResponse(array(
            'status'=>'SUCCESS',
            'msg'=>'Document Successfully Delete'
            )
        );
    }

}