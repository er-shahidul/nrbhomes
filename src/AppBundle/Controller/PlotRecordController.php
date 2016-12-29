<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\PlotRecord;
use AppBundle\Entity\PurchasedLand;
use AppBundle\Entity\PurchasedLandRelation;
use AppBundle\Form\PlotRecordType;
use AppBundle\Form\PurchasedLandType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PlotRecordController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $plotRecords = $em->getRepository('AppBundle:PlotRecord')->getPlotRecordList();
        $paginator  = $this->get('knp_paginator');
        $paginations = $paginator->paginate(
            $plotRecords, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );
        //var_dump(count($paginations));
        return $this->render('AppBundle:PlotRecord:index.html.twig', array(
            'plots'=>$paginations
        ));
    }

    public function createPlotRecordAction(Request $request )
    {

        $plotRecord = new PlotRecord();
        //var_dump('ok');die;
        $form = $this->createForm(PlotRecordType::class, $plotRecord);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $formData['meta_data'] = $request->request->get('meta_data');
                $formData['files'] = $request->files->all();
                $this->get('app_bundle.service.nrbhome_manager')->createPlotRecord($plotRecord, $formData);
                return $this->redirect($this->generateUrl('plot_record_list'));
            }
        }
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('plot_record_add');
        return $this->render('AppBundle:PlotRecord:add.html.twig',$data);

    }

    public function updatePlotRecordAction(Request $request, PlotRecord $plotRecord )
    {

        $existDocument = $this->getDoctrine()->getRepository('AppBundle:Document')->findBy(array('plotRecord'=>$plotRecord));
        $form = $this->createForm(PlotRecordType::class, $plotRecord);
//        var_dump('ok');die;
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {
                $formData['meta_data'] = $request->request->get('meta_data');
                $formData['files'] = $request->files->all();
                $this->get('app_bundle.service.nrbhome_manager')->createPlotRecord($plotRecord, $formData);
                return $this->redirect($this->generateUrl('plot_record_list'));
            }
        }
        $data['documents'] = $existDocument;
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('plot_record_update',array('id'=>$plotRecord->getId()));
        return $this->render('AppBundle:PlotRecord:add.html.twig',$data);

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