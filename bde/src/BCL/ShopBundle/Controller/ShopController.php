<?php

// src/BCL/ShopBundle/Controller/ShopController.php

namespace BCL\ShopBundle\Controller;

use BCL\ShopBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\HttpFoundation\Request;


class ShopController extends Controller
{
    public function indexAction()
    {
        $articles = $this->getDoctrine()->getManager()->getRepository('BCLShopBundle:Article')->findAll();
        return $this->render('BCLShopBundle:Shop:article.html.twig', array('articles' => $articles));
    }

    public function cartAction()
    {
        return $this->render('BCLShopBundle:Shop:cart.html.twig');
    }

    public function addArticleAction(Request $request)
    {
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

                return $this->redirectToRoute($this->generateUrl('BCL_Shop_homepage'));
            }
        }

        return $this->render('BCLShopBundle:Shop:newArticle.html.twig', array('form' => $form->createView() ));
    }
}