<?php

namespace BCL\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BCLUserBundle:Default:index.html.twig');
    }
}
