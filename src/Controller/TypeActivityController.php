<?php

namespace App\Controller;

use App\Entity\TypeActivity;
use App\Repository\TypeActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/activity")
 */
class TypeActivityController extends AbstractController
{
    /**
     * @Route("/", name="type_activity")
     */
    public function index(Request $request, TypeActivityRepository $typeActivityRepository): Response
    {
        $typeActivityRepository = $this->getDoctrine()->getRepository(TypeActivity::class);
        $typeActivity = $typeActivityRepository->findAll();

        return $this->render('type_activity/index.html.twig', [
            'typeActivity' => $typeActivity,
        ]);
    }
}
