<?php

// src/BLC/UserBundle/Controller

namespace BCL\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function indexAction()
    {
        return new Response("Ici il y aura vos utilisateurs");
    }
}
