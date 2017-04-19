<?php

// src/BLC/UserBundle/Controller

namespace BCL\UserBundle\Controller;

use BCL\UserBundle\Entity\Schoolyear;
use BCL\UserBundle\Entity\Status;
use BCL\UserBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function indexAction()
    {
        return new Response("Ici il y aura vos utilisateurs");
    }

    public function removeUserAction($id)
    {

    }

    public function signInAction(Request $request)
    {
        /*$user = new Users();
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

        $entityManager->flush();*/

        $user = new Users();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('firstName', TextType::class)
            ->add('lastName',   TextType::class)
            ->add('email',  TextType::class)
            ->add('password',   PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            //->add('status',     TextType::class)
            ->add('validate',   SubmitType::class)
            ->getForm();

        if($request->isMethod('POST'))
        {
            $formBuilder->handleRequest($request);

            if($formBuilder->isValid())
            {
                if($user->getPassword() === $user->getConfirmPassword())
                {
                    $em = $this->getDoctrine()->getManager();
                    $repo = $em->getRepository("BCLUserBundle:Status");
                    $status = $repo->findBy(array('name'=>'Student'), $orderBy = null, $limit = 1, $offset = 0);


                    $user->setStatus($status[0]);

                    $em->persist($user);


                    $em->flush();

                    return new RedirectResponse($this->generateUrl('bcl_user_profil', array('id' => $user->getId())));
                }

            }
        }



        return $this->render('BCLUserBundle:User:signIn.html.twig', array('form' => $formBuilder->createView()));
    }

    public function logInAction()
    {

    }

    public function logOutAction()
    {

    }

    public function viewProfilAction($id)
    {
        return new Response("Afficher l'utilisateur $id");
    }
}
