<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DagNumber;
use AppBundle\Entity\Mouza;
use AppBundle\Form\DagNumberType;
use AppBundle\Form\MouzaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DagNumberController extends Controller
{

    public function createDagNumberAction(Request $request, $mouzaId )
    {
        //var_dump($mouzaId);die;
        $dagNumber = new DagNumber();
        $mouza = $this->getDoctrine()->getRepository('AppBundle:Mouza')->find($mouzaId);

        $form = $this->createForm(DagNumberType::class, $dagNumber, array('mouzaId'=>$mouza));

        if ($request->isMethod('POST')) {

            $form->handleRequest($request);
            if ($form->isValid()) {

               $newDagNumber = $this->get('app_bundle.service.nrbhome_manager')->createDagNumber($dagNumber);

                $data= array(
                    'succ' => 'SUCCESS',
                    'newDagNumber' => $newDagNumber
                );

                $response = new Response(json_encode($data)) ;
                return $response;
            }
        }
        $data['form'] = $form->createView();
        return $this->render('AppBundle:Dagnumber:add-dag-number.html.twig',$data);

    }

    public function getDagNumberAction(Mouza $mouza, $dagId){

        $dagNumbers = $this->getDoctrine()->getRepository('AppBundle:DagNumber')->getDagNumbersByMouza($mouza);
        $data = array();

        foreach ($dagNumbers as $dagNumber) {
            $selectedDagNumber = ($dagNumber->getId()==$dagId)?'selected="selected"':"";
            $data [] = '<option value="' . $dagNumber->getId() . '" '. $selectedDagNumber.'>' . $dagNumber->getDagNumberName() . '</option>';
        }

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}