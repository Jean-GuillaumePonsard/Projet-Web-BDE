<?php

// src/BCL/ActivityBundle/Controller/ActivityController.php

namespace BCL\ActivityBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class ActivityController
{

    public function indexAction()
    {
        return new Response("Bonjour, ceci est la page qui contiendra les activitées");
    }
}