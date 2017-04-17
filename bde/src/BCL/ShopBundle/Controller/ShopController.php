<?php

// src/BCL/ShopBundle/Controller/ShopController.php

namespace BCL\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{
    public function indexAction()
    {
        return new Response("Bonjour, ceci est la page qui contiendra le shop, c'est donc l'endroit où vous pourrez acheter votre ford mustang");
    }
}