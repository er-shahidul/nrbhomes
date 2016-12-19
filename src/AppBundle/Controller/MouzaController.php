<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mouza;
use AppBundle\Form\MouzaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MouzaController extends Controller
{

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $mouzas = $em->getRepository('AppBundle:Mouza')->findBy(array('approved'=>1));
        //var_dump($purchasedLands);die;
        return $this->render('AppBundle:Mouza:list.html.twig', array(
            'mouzas'=>$mouzas
        ));
    }
    public function createMouzaAction(Request $request )
    {

        $mouza = new Mouza();
        $form = $this->createForm(MouzaType::class, $mouza);

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

                $this->get('app_bundle.service.nrbhome_manager')->createMouza($mouza);

                return $this->redirect($this->generateUrl('mouzas_list'));
            }
        }
        $data['form'] = $form->createView();
        $data['form_action'] = $this->generateUrl('mouza_add');
        return $this->render('AppBundle:Mouza:add-mouza.html.twig',$data);

    }

}