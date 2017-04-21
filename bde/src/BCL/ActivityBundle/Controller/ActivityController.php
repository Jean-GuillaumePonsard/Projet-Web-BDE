<?php

// src/BCL/ActivityBundle/Controller/ActivityController.php

namespace BCL\ActivityBundle\Controller;

use BCL\ActivityBundle\BCLActivityBundle;
use BCL\ActivityBundle\Entity\Activity;
use BCL\ActivityBundle\Entity\Gallery;
use BCL\ActivityBundle\Entity\Picture_Gallery;
use BCL\ActivityBundle\Entity\PictureComment;
use Symfony\Component\DomCrawler\Image;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;
use BCL\ActivityBundle\Entity\ActivityIdea;
use BCL\UserBundle\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ActivityController extends Controller
{

    public function indexAction()
    {
        return $this->redirectToRoute('bcl_activity_futuractivities');
    }

    public function showAllPastActivitiesAction($page)
    {
        $nbPerPage = 4;
        $em = $this->getDoctrine()->getManager();
        $a = new \DateTime(date('Y-m-d'));
        $Allactivitypast = $em->getRepository('BCLActivityBundle:Activity')->findByActivityStatus($em->getRepository('BCLActivityBundle:ActivityStatus')->findOneBy(array('nameStatus'=>'Past')));
        foreach ($Allactivitypast as $pastActivity) {
            $s = $pastActivity->getDateCloseVote();
            if (!is_null($s))
            {
                if ($s < $a)
                {
                    $dates = null;
                    $dates= $em->getRepository('BCLActivityBundle:ActivityDate')->findByActivity($pastActivity->getId());

                    foreach ($dates as $date) {
                        if (!is_null($date->getUser())) {
                            $nb = count($date->getUser());

                            $d = $date->getDateActivity()->format('F d Y');
                            $vote = array($d => $nb);

                            if (isset($vote)) {

                                while ($nbvote = current($vote)) {
                                    if ($nbvote == max($vote)) {
                                        $dateFinal = key($vote);
                                        $pastActivity->setDateF($dateFinal);
                                    }
                                    next($vote);
                                }

                                if (is_null($pastActivity->getDateF()))
                                {
                                    $pastActivity->setDateF($d);
                                }

                            }

                        }
                    }
                }
            }
        }
        $pastActivities = $em ->getRepository('BCLActivityBundle:Activity')
            ->findAllActivities('Past',$page,$nbPerPage);

        $nbPages = ceil(count($pastActivities)/$nbPerPage);
        return $this->render('BCLActivityBundle:Activity:pastActivities.html.twig', array(
            'pastActivities' => $pastActivities,
            'page'=>$page,
            'nbPages'=> $nbPages));
    }


    public function showAllFutureActivitiesAction($page)
    {
        $nbPerPage = 4;

        $em = $this->getDoctrine()->getManager();
        $Allactivity = $em->getRepository('BCLActivityBundle:Activity')->findByActivityStatus($em->getRepository('BCLActivityBundle:ActivityStatus')->findOneBy(array('nameStatus'=>'Future')));
        foreach ($Allactivity as $value)
        {
            $s = $value->getDateCloseVote();
            //$today = new \DateTime(date('Y-m-d'));
            $a = new \DateTime(date('Y-m-d'));
            if (!is_null($s))
            {if ($s <$a)
            {

                $dates = $em->getRepository('BCLActivityBundle:ActivityDate')->findByActivity($value->getId());
                foreach ($dates as $date)
                {
                    foreach ($dates as $date)
                    {

                        if (!is_null($date->getUser())) {
                            $nb = count($date->getUser());

                            $d = $date->getDateActivity()->format('F d Y');
                            $vote = array($d => $nb);

                            if (isset($vote)) {

                                while ($nbvote = current($vote)) {
                                    if ($nbvote == max($vote)) {
                                        $dateFinal = key($vote);
                                        $value->setDateF($dateFinal);
                                    }
                                    next($vote);
                                }

                                if (is_null($value->getDateF()))
                                {
                                    $value->setDateF($d);
                                }
                            }
                        }
                    }
                }
            }
            }
            if (!is_null($value->getDateF())) {
                $f = new \DateTime($value->getDateF());
                $f->format('Y-m-d');

                if ($f < $a) {

                    $value->setActivityStatus($em->getRepository('BCLActivityBundle:ActivityStatus')->findOneBy(array('nameStatus' => 'Past')));
                    $gallery = new Gallery();
                    $value->setGallery($gallery);
                    $em->persist($value);
                    $em->flush();
                }
            }
        }
        $futureActivities = $em ->getRepository('BCLActivityBundle:Activity')
            ->findAllActivities('Future',$page,$nbPerPage);
        $nbPages = ceil(count($futureActivities)/$nbPerPage);

        return $this->render('BCLActivityBundle:Activity:futureActivities.html.twig', array(
            'futureActivities' => $futureActivities,
            'page'=>$page,
            'nbPages'=> $nbPages));
    }

    public function showAllProposalsAction($page)
    {
        $nbPerPage = 4;
        $em = $this->getDoctrine()->getManager();
        $proposals = $em ->getRepository('BCLActivityBundle:ActivityIdea')
            ->findAllProposals($page,$nbPerPage);
        $nbPages = ceil(count($proposals)/$nbPerPage);



        return $this->render('BCLActivityBundle:Activity:proposals.html.twig', array(
            'proposals' => $proposals,
            'page'=>$page,
            'nbPages'=> $nbPages));
    }

    public function showPastActivityAction($id,$id2, Request $query)
    {

        $em = $this->getDoctrine()->getManager();
        $pastActivity = $em ->getRepository('BCLActivityBundle:Activity')
            ->find( $id);

        $gallery = $pastActivity->getGallery();

        $images =$em ->getRepository('BCLActivityBundle:Picture_Gallery')
            ->findAllPicture($gallery);

        $image = $em ->getRepository('BCLActivityBundle:Picture_Gallery')
            ->find($id2);

        $newImage = new Picture_Gallery();
        $newImage->setGallery($gallery);
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $newImage)
            ->add('urlPicture',  UrlType::class)
            ->add('add',   SubmitType::class)
            ->getForm();

        if($query->isMethod('POST'))
        {
            $formBuilder->handleRequest($query);
            if($formBuilder->isValid())
            {
                $em->persist($newImage);
                $em->flush();
                return new RedirectResponse($this->generateUrl('bcl_activity_pastActivity', array('id'=>$id, 'id2'=>$newImage->getId())));
            }
            return new RedirectResponse($this->generateUrl('bcl_activity_pastActivity', array('id'=>$id, 'id2'=>$id2)));
        }

        if(!empty($image))
        {
            if(!empty($query->query->get('like')))
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

                $addlike = true;
                foreach ($image->getPersonsWhoLiked() as $personWhoLike )
                {
                    if($user === $personWhoLike)
                    {
                        $addlike = false;
                    }
                }
                if($addlike)
                {
                    $image->addPersonsWhoLiked($user);

                    $em->persist($image);
                    $em->flush();
                }
            }

            if(!empty($query->query->get('comment')))
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

                $pictureComment = new PictureComment();

                $pictureComment->setUserCommented($user);
                $pictureComment->setContent($query->query->get('comment'));
                $pictureComment->setImageCommented($image);

                $em->persist($pictureComment);
                $em->flush();

                return new RedirectResponse($this->generateUrl('bcl_activity_pastActivity', array('id'=>$id, 'id2'=>$id2)));

            }

            $nblike =count($image->getPersonsWhoLiked());
            $picture = $image->getId();
            $comment =$em ->getRepository('BCLActivityBundle:PictureComment')
                ->findAllComment($picture);


            $nbcomment =count($comment);
        }else
        {
            $nblike = null;
            $picture = null;
            $comment = null;
            $nbcomment = null;
        }

        return $this->render('BCLActivityBundle:Activity:pastActivitiesEx.html.twig', array(
            'pastActivity' => $pastActivity,
            'images'=>$images,
            'image'=> $image,
            'like'=>$nblike,
            'comments'=>$comment,
            'comment'=>$nbcomment,
            'form'=>$formBuilder->createView()));
    }

    public function showProposalAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $proposal = $em ->getRepository('BCLActivityBundle:ActivityIdea')
            ->find($id);


        return $this->render('BCLActivityBundle:Activity:proposalEx.html.twig', array(
            'proposal' => $proposal));
    }

    public function showFutureActivityAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $futureActivity = $em ->getRepository('BCLActivityBundle:Activity')
            ->find($id);

        $v = $futureActivity->getDateCloseVote();
        $s = $futureActivity->getDateCloseSubscribe();
        //$today = new \DateTime(date('Y-m-d'));
        $a = new \DateTime(date('Y-m-d'));


        if ($s > $a and $v < $a)
        {
            $b = 2;
        }
        elseif($v > $a)
        {
            $b = 1;
        }else{$b = 1;}

        return $this->render('BCLActivityBundle:Activity:futurActivitiesEx.html.twig', array(
            'futureActivity' => $futureActivity,'b'=> $b));
    }

    public function newProposalAction(Request $request)
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


        $user = new Users();
        $user = $this->getDoctrine()->getManager()->getRepository('BCLUserBundle:Users')->find($userId);

        $activityIdea = new ActivityIdea();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $activityIdea)
            ->add('nameActivityIdea',           TextType::class)
            ->add('descriptionActivityIdea',    TextareaType::class)
            ->add('urlPictureActivityIdea',    UrlType::class)
            ->add('validate',                   SubmitType::class)
            ->getForm()
        ;

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();
                $activityIdea->setUserCreator($user);
                $em->persist($activityIdea);
                $em->flush();
                return new RedirectResponse($this->generateUrl('bcl_activity_proposals', array('page'=> '1')));
            }
        }

        return $this->render('BCLActivityBundle:Activity:proposalForm.html.twig', array('form' => $form->createView()));
    }


    public function newFuturactivityAction(Request $request)
    {
        $activity = new Activity();
        $activity->setActivityStatus($this->getDoctrine()->getManager()->getRepository('BCLActivityBundle:ActivityStatus')->findByNameStatus("Future")[0]);


        $form = $this->get('form.factory')->createBuilder(FormType::class, $activity)
            ->add('name',               TextType::class)
            ->add('description',        TextareaType::class)
            ->add('dateCloseVote',      DateType::class)
            ->add('dateCloseSubscribe', DateType::class)
            ->add('urlPicture',         UrlType::class)
            ->add('validate',           SubmitType::class)
            ->getForm()
        ;

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $em->persist($activity);

                $em->flush();

                return new RedirectResponse($this->generateUrl('bcl_activity_futuractivities',array('page'=>'1')));
            }

        }
        return $this->render('BCLActivityBundle:Activity:newFutureActivity.html.twig', array('form' => $form->createView()));
    }


}