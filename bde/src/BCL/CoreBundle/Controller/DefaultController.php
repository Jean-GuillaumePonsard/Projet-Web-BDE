<?php

namespace BCL\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BCLCoreBundle:Default:index.html.twig');
    }
}
