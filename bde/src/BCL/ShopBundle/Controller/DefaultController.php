<?php

namespace BCL\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BCLShopBundle:Default:index.html.twig');
    }
}
