<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //ajout de l'utilisateur

        $user = new User();
        $user->setRoles(['ROLE_AMBASSADOR']);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // On vérifie si l'utilisateur est un bot (Si is_verified = 1 alors c'est un bot)
            if($user->isVerified() == false) {
                return $this->redirectToRoute("app_register");
                $this->addFlash('message', 'Merci de bien vouloir réessayer votre inscription');
            }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            //$this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                //(new TemplatedEmail())
                    //->from(new Address('stage.symfony2021@gmail.com', 'Stage Mail Bot'))
                    //->to($user->getEmail())
                    //->subject('Please Confirm your Email')
                   // ->htmlTemplate('registration/confirmation_email.html.twig')
            //);



            return $this->redirectToRoute('app_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre addresse email a été bien verifié.');

        return $this->redirectToRoute('app_index');
    }

    /**
     * Permet de créer le token pour activer le compte de l'utilisateur
     * @Route("/activation/{token}", name="activation")
     */

    public function activation($token, UserRepository $userRepository)
    {
        //On verifie si l'utilisateur a un token

        $user = $userRepository->findOneBy(['activation_token' => $token]);

        //si aucun utilisateur n'existe pas dans la base de données avec ce token
        if(!$user){
            //Erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas dans la base de données!');
        }
        //on supprime le token
        $user->setActivationToken(null);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        // on envoie un message
        $this->addFlash('message', 'Votre compte a été bien activé');

        // on retourne à la homepage
        return $this->redirectToRoute('app_index');
    }
}
