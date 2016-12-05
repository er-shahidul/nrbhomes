<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{

    public function indexAction(Request $request)
    {
        $data =  $this->getUser();
        return $this->render('AppBundle:dashboard:index.html.twig',
            array(
                'users'=> $data,
            )
        );
    }
}
