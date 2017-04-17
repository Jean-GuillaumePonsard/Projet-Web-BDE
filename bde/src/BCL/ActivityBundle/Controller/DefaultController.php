<?php

namespace BCL\ActivityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BCLActivityBundle:Default:index.html.twig');
    }
}
