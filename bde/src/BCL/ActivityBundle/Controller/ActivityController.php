<?php

// src/BCL/ActivityBundle/Controller/ActivityController.php

namespace BCL\ActivityBundle\Controller;

use BCL\ActivityBundle\BCLActivityBundle;
use BCL\ActivityBundle\Entity\Activity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

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

    public function showPastActivityAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pastActivity = $em ->getRepository('BCLActivityBundle:Activity')
            ->find($id);

        $gallery = $pastActivity->getGallery();

        $images =$em ->getRepository('BCLActivityBundle:Picture_Gallery')
            ->findAllPicture($gallery);

        return $this->render('BCLActivityBundle:Activity:pastActivitiesEx.html.twig', array(
            'pastActivity' => $pastActivity,
            'images'=>$images));
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
        }

        return $this->render('BCLActivityBundle:Activity:futurActivitiesEx.html.twig', array(
            'futureActivity' => $futureActivity,'b'=> $b));
    }


}