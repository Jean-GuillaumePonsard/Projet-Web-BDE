<?php

// src/BLC/UserBundle/Controller

namespace BCL\UserBundle\Controller;

use BCL\UserBundle\BCLUserBundle;
use BCL\UserBundle\Entity\Schoolyear;
use BCL\UserBundle\Entity\Status;
use BCL\UserBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        $user = new Users();

        /*$everyStatus = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Status')->findAll();
        foreach ($everyStatus as $status)
        {

        }*/




        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('firstName', TextType::class)
            ->add('lastName',   TextType::class)
            ->add('email',  EmailType::class)
            ->add('password',   PasswordType::class)
            ->add('confirmPassword', PasswordType::class)
            ->add('status',     ChoiceType::class, array('choices' => $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Status')->findAll(), 'choice_label' => 'name'))
            ->add('validate',   SubmitType::class)
            ->getForm();

        if($request->isMethod('POST'))
        {
            $formBuilder->handleRequest($request);

            if($formBuilder->isValid())
            {
                $emailPossible = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->findByEmail($user->getEmail());

                if(empty($emailPossible) == "empty")
                {

                    if($user->getPassword() === $user->getConfirmPassword())
                    {
                        $em = $this->getDoctrine()->getManager();
                        /*$repo = $em->getRepository("BCLUserBundle:Status");
                        $status = $repo->findBy(array('name'=>'Student'), $orderBy = null, $limit = 1, $offset = 0);
                        $user->setStatus($status[0]);*/

                        $em->persist($user);


                        $em->flush();

                        return new RedirectResponse($this->generateUrl('bcl_user_profil', array('id' => $user->getId())));
                    }
                }
                echo "<script>alert('Ce compte existe déjà')</script>";
            }
        }



        return $this->render('BCLUserBundle:User:signIn.html.twig', array('form' => $formBuilder->createView()));
    }

    public function logInAction(Request $request)
    {
        $user = new Users();

        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('email',  EmailType::class)
            ->add('password',   PasswordType::class)
            ->add('validate',   SubmitType::class)
            ->getForm();

        if($request->isMethod('POST'))
        {
            $formBuilder->handleRequest($request);

            if($formBuilder->isValid())
            {
                $emailPossible = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->findByEmail($user->getEmail());

                if(empty($emailPossible) != "empty")
                {
                    if($emailPossible[0]->getPassword() == $user->getPassword())
                    {
                        echo "<script>alert('".$emailPossible[0]->getFirstName()."".$emailPossible[0]->getLastName()." tries to connect')</script>";

                        return new RedirectResponse($this->generateUrl('bcl_user_profil', array('id' => $emailPossible[0]->getId())));
                    }
                }
                echo "<script>alert('This account doesn t exist or wrong password')</script>";
            }
        }
        return $this->render('BCLUserBundle:User:logIn.html.twig', array('form' => $formBuilder->createView()));
    }

    public function logOutAction()
    {

    }

    public function viewProfilAction($id)
    {
        return new Response("Afficher l'utilisateur $id");
    }
}
