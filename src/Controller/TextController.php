<?php

namespace App\Controller;



use App\Repository\TextRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/text")
 */
class TextController extends AbstractController
{
    /**
     * @Route("/confidentialite", name= "text_confidentialite")
     */
    public function confidentialite(TextRepository  $textRepository): Response
    {

        $text = $textRepository->findOneBy(['id'=> 4]);
        return $this->render('text/index.html.twig',[
            'text'=>$text

        ]);
    }


    /**
     * @Route("/about", name= "text_about")
     */
    public function about(TextRepository  $textRepository): Response
    {

        $text = $textRepository->findOneBy(['id'=> 3]);
        return $this->render('text/index.html.twig',[
            'text'=> $text

        ]);
    }


    /**
     * @Route("/condition", name= "text_condition")
     */
    public function condition(TextRepository  $textRepository): Response
    {

        $text = $textRepository->findOneBy(['id'=> 2]);
        return $this->render('text/index.html.twig',[
            'text'=> $text

        ]);
    }


}

