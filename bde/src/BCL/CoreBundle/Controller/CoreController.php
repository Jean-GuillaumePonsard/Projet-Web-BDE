<?php

// src/BCL/CoreBundle/Controller/CoreController.php

namespace BCL\CoreBundle\Controller;

use BCL\CoreBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('BCLCoreBundle::home.html.twig', array('user' => ""));
    }


    public function legalNoticesAction()
    {
        return $this->render('BCLCoreBundle::LegalNotices.html.twig');
    }

    public function bdeMembersAction()
    {
        return $this->render('BCLCoreBundle::BDEmember.html.twig');
    }


    public function contactAction(Request $request)
    {
        $contact = new Contact();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $contact)
            ->add('name',       TextType::class)
            ->add('email',      EmailType::class)
            ->add('subject',    TextType::class)
            ->add('body',    TextareaType::class)
            ->add('send',       SubmitType::class)
            ->getform()
        ;

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact from BCL')
                    ->setFrom('adrien.thevenet@viacesi.fr')
                    ->setTo($this->container->getParameter('bcl_core.emails.contact_email'))
                    ->setBody($this->renderView('BCLCoreBundle::contactEmail.txt.twig', array('contact' => $contact)));
                $this->get('mailer')->send($message);


                return $this->redirectToRoute($this->generateUrl('bcl_core_homepage'));
            }
        }

        return $this->render('BCLCoreBundle::contact.html.twig', array('form' => $form->createView()));
    }
}
