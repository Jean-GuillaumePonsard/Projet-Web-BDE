<?php

// src/BCL/CoreBundle/Controller/CoreController.php

namespace BCL\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CoreController extends Controller
{
    public function indexAction()
    {
        return new Response("Bonjour, ceci est la page qui contiendra le core, donc le home, shop et user");
    }
}
