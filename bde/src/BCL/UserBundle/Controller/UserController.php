<?php

// src/BLC/UserBundle/Controller

namespace BCL\UserBundle\Controller;

use BCL\UserBundle\Entity\Schoolyear;
use BCL\UserBundle\Entity\Status;
use BCL\UserBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    public function indexAction()
    {
        return new Response("Ici il y aura vos utilisateurs");
    }

    public function removeUserAction($id)
    {

    }

    public function signInAction()
    {
        $user = new Users();
        $user->setFirstName("Aurelia");
        $user->setLastName("Besse");
        $user->setEmail("aurelia.besse@viacesi.fr");
        $user->setPassword("password");
        $user->setUrlPicture("https://media.licdn.com/mpr/mpr/shrinknp_400_400/AAEAAQAAAAAAAAvPAAAAJDE0Mzg1YzAwLWI3ZGYtNDhmZi05NWQ1LWJiMjg3NjYzYzM0YQ.jpg");

        $status = new Status();
        $status->setName("Admin");

        $user->setStatus($status);

        $schoolyear = new Schoolyear();
        $schoolyear->setName("EXIA A2");

        $user->setSchoolyear($schoolyear);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($status);
        $entityManager->persist($schoolyear);
        $entityManager->persist($user);

        $entityManager->flush();

        return new Response("Aurelia voulait être admin");
    }

    public function logInAction()
    {

    }

    public function logOutAction()
    {

    }
}
