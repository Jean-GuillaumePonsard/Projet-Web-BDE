<?php

// src/BCL/CoreBundle/Controller/CoreController.php

namespace BCL\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('::layout.html.twig', array('user' => ""));
    }

    public function homepageAction()
    {
        return $this->render('BCLCoreBundle::home.html.twig');
    }

    public function legalNoticesAction()
    {
        return $this->render('BCLCoreBundle::LegalNotices.html.twig');
    }
}
