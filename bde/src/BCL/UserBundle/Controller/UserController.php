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
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\HttpFoundation\Session\Session;



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
                       $ok=$this->get('session');
                       $ok->set('userId',array($emailPossible[0]->getId()));
                        $ok->set('status',array($emailPossible[0]->getStatus()->getName()));


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
        $ok=$this->get('session');
        $ok->remove('userId');
        $ok->remove('status');
        return $this->render('BCLCoreBundle::home.html.twig');
    }

    public function viewProfilAction($id, Request $request)
    {
        $user = new Users();
        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($id);
        /*if (!is_null($_SESSION["status"]))
        {
            echo "<script>alert('bonjour')</script>";

        }*/
        //Form
        $form = $this->get('form.factory')->createBuilder(FormType::class, $user)
            ->add('urlPicture',  TextType::class, array('required'=>false))
            ->add('firstName',  TextType::class)
            ->add('lastName',  TextType::class)
            ->add('email',  EmailType::class)
            ->add('modify',   SubmitType::class)
            ->getForm();


        if($request->isMethod('POST'))
        {
            // Verifying every form to check what to change

            $form->handleRequest($request);

            if($form->isSubmitted())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return new RedirectResponse($this->generateUrl('bcl_user_profil', array('id' => $id)));
            }
        }

        return $this->render('BCLUserBundle:User:profil.html.twig', array('profil'=>$user, 'form' => $form->createView()));
    }
}
