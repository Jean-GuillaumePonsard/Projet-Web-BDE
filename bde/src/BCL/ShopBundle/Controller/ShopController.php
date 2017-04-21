<?php

// src/BCL/ShopBundle/Controller/ShopController.php

namespace BCL\ShopBundle\Controller;

use BCL\ShopBundle\Entity\Article;
use BCL\ShopBundle\Entity\ClientOrder;
use BCL\ShopBundle\Entity\To_Compose;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ShopController extends Controller
{
    public function indexAction()
    {
        $articles = $this->getDoctrine()->getManager()->getRepository('BCLShopBundle:Article')->findByActive(true);
        return $this->render('BCLShopBundle:Shop:article.html.twig', array('articles' => $articles));
    }

    public function cartAction()
    {
        // user Id is defined with a session parameter
        $session = $this->get('session');
        if(!empty($session->get('userId')))
        {
            $userId = $session->get('userId')[0];
        }
        else
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($userId);
        if($user == null)
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        // Get Last Client Cart
        $cart = new ClientOrder();
        $toCompose = new To_Compose();
        $cartArticles = array();

        $manager = $this->getDoctrine()->getManager();
        $clientOrderRepo = $manager->getRepository('BCLShopBundle:ClientOrder');

        if(!empty($clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)))
        {
            $cart = $clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)[0];

            $cartArticles = $manager->getRepository('BCLShopBundle:To_Compose')->findByClientOrder($cart);
        }else
        {
            $cartArticles[0] =  $toCompose;
        }


        return $this->render('BCLShopBundle:Shop:cart.html.twig', array('cartArticles' => $cartArticles ));
    }

    public function addArticleAction(Request $request)
    {
        $session = $this->get('session');
        if(!empty($session->get('userId')))
        {
            $userId = $session->get('userId')[0];
        }
        else
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($userId);
        if($user == null)
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        if($user->getStatus()->getName() != 'Teacher' AND $user->getStatus()->getName() != 'Admin')
        {
            return new Response('Access Denied', Response::HTTP_UNAUTHORIZED);
        }

        $article = new Article();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $article)
            ->add('name',           TextType::class)
            ->add('description',    TextareaType::class)
            ->add('price',          NumberType::class)
            ->add('urlPicture',     UrlType::class)
            ->add('validate',       SubmitType::class)
            ->getForm()
        ;

         if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return new RedirectResponse($this->generateUrl('bcl_shop_homepage'));
            }
        }

        return $this->render('BCLShopBundle:Shop:newArticle.html.twig', array('form' => $form->createView() ));
    }

    public function addArticleToCartAction($id, Request $query)
    {
        // user Id is defined with a session parameter

        $session = $this->get('session');
        if(!empty($session->get('userId')))
        {
            $userId = $session->get('userId')[0];
        }
        else
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($userId);

        if($user == null)
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        // Get Last Client Cart
        $cart = new ClientOrder();

        $manager = $this->getDoctrine()->getManager();
        $clientOrderRepo = $manager->getRepository('BCLShopBundle:ClientOrder');

        if(!empty($clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)))
        {
            $cart = $clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)[0];
        }else
        {
            $cart->setClient($user);
            $cart->setPaid(0);

            $manager->persist($cart);
            $manager->flush();
        }

        // Creating a new To Compose Object to match the cart and the product
        $quantityProduct = (int)$query->query->get('quantity');

        //Set Quantity
        $toCompose = new To_Compose();
        if(!empty($quantityProduct) AND $quantityProduct > 0)
        {
            $toCompose->setQuantity($quantityProduct);
        }
        else{
            throw new Exception();
        }

        //Set Article
        $articleRepo = $manager->getRepository('BCLShopBundle:Article');
        $article = $articleRepo->find($id);

        if(empty($article))
        {
            throw new Exception();
        }

        $toCompose->setArticle($article);

        //Set Client Cart
        $toCompose->setClientOrder($cart);

        $manager->persist($toCompose);
        $manager->flush();

        return new RedirectResponse($this->generateUrl('bcl_shop_homepage'));
    }

    public function payCartAction()
    {
        // user Id is defined with a session parameter
        $session = $this->get('session');
        if(!empty($session->get('userId')))
        {
            $userId = $session->get('userId')[0];
        }
        else
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($userId);
        if($user == null)
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        // Get Last Client Cart
        $manager = $this->getDoctrine()->getManager();
        $clientOrderRepo = $manager->getRepository('BCLShopBundle:ClientOrder');

        if(!empty($clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)))
        {
            $cart = $clientOrderRepo->findBy(array('client' => $userId,'paid'=>0 ), array('dateOrder'=>'DESC'), 1, 0)[0];
        }else
        {
            return new RedirectResponse($this->generateUrl('bcl_shop_homepage'));
        }

        $cart->setPaid(true);

        $manager->persist($cart);
        $manager->flush();

        return new RedirectResponse($this->generateUrl('bcl_shop_homepage'));
    }

    public function removeArticleAction($id)
    {
        $session = $this->get('session');
        if(!empty($session->get('userId')))
        {
            $userId = $session->get('userId')[0];
        }
        else
        {
            return new RedirectResponse($this->generateUrl('bcl_user_logIn'));
        }

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('BCLUserBundle:Users')->find($userId);

        if(!($user->getStatus()->getName() == "Admin" OR $user->getStatus()->getName() == "Teacher"))
        {
            throw $this->createAccessDeniedException('Access Denied');
        }

        $article = new Article();
        $article = $em->getRepository('BCLShopBundle:Article')->find($id);

        if(empty($article))
        {
            throw $this->createNotFoundException('Impossible to find article');
        }

        $article->setActive(false);

        $em->persist($article);

        $em->flush();

        return new RedirectResponse($this->generateUrl('bcl_shop_homepage'));

    }
}