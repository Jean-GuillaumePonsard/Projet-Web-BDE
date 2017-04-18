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
}
