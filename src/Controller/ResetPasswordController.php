<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    /**
     * La requete pour reinitialiser le mot de passe
     * @Route("/request", name="request_password")
     */
    public function request(UserRepository $userRepository, Request $request): Response
    {
        $user = $userRepository->findOneBy(['email'=>$request->request->get('email')]);
        if($user){
            return $this->redirectToRoute('reset_password', ['id'=>$user->getId()]);
        }elseif ($request->isMethod('POST')){
            $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/request.html.twig');
    }
    /**
     * la fonction qui permet de réinitialiser le mot de passe
     * @Route ("/reset/{id}", name="reset_password", requirements = {"id": "\d+"})
     */
    public function reset(Request $request, UserPasswordEncoderInterface $encoder, User $user, EntityManagerInterface $manager)
    {
        $form =$this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //on va encoder le password
            $hashed = $encoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($hashed);
            $manager->flush();

            return $this->redirectToRoute('app_login');


        }
        return $this->render('reset_password/reset.html.twig',[
            'form'=>$form->createView(),
        ]);


    }
}
