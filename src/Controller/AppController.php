<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("", name="app_index")
     */
    public function index(ActivityRepository $activityRepository): Response
    {
        $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
        $activities = $activityRepository->TopTenRecentActivitiesPublished();

        //return $this->redirectToRoute('activity_index');

        return $this->render('app/index.html.twig', [
            'activities' => $activities,
        ]);
    }
}