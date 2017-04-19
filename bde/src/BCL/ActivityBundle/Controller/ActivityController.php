<?php

// src/BCL/ActivityBundle/Controller/ActivityController.php

namespace BCL\ActivityBundle\Controller;

use BCL\ActivityBundle\BCLActivityBundle;
use BCL\ActivityBundle\Entity\Activity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function showAllFutureActivitiesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $futureActivities = $em ->getRepository('BCLActivityBundle:Activity')
            ->findAllActivities('Future');
        /*$repo = $em ->getRepository('BCLActivityBundle:Activity');

        $pastActivities = $repo->findBy(array('activityStatus'=>($em->
        getRepository('BCLActivityBundle:ActivityStatus')->findByNameStatus('Past')[0]->getId())));*/

        return $this->render('BCLActivityBundle:Activity:futureActivities.html.twig', array('futureActivities' => $futureActivities));
    }
}