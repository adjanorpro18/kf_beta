<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileEditType;
use App\Form\UserType;
use App\Repository\ProfileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder, ProfileRepository $profileRepository): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_AMBASSADEUR']);
        $user->getProfile();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            // hasher le mot d epasse
            $hashed = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hashed);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hashed = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hashed);
            $this->getDoctrine()->getManager()->flush();

           $this->addFlash('success', 'Votre profil a bien été mis à jour !');
            return $this->redirectToRoute('app_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user, TokenStorageInterface $tokenStorage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            // Réinitialiser l'utilisateur en anonyme
            $this->get('security.token_storage')->setToken(null);
            $this->addFlash('success', 'Votre compte a bien été supprimé !');
        }

        return $this->redirectToRoute('app_index');
    }

    /**
     * Consulter son propre profil
     * @Route ("/{id}/profile", name="user_profile", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function profile($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Modifier son profil
     * @Route ("/profile/{id}/edit/", name="user_profile_edit", requirements={"id": "\d+"}, methods={"GET","POST"})
     */
    public function userProfileEdit(Request $request, $id, UserRepository $userRepository, Profile $profile, ProfileRepository $profileRepository)
    {
        $user = $userRepository->find($id);
        $user = $this->getUser();
        $profile = $this->getDoctrine()->getRepository(Profile::class)->findOneBy(array('id'));
        $user =$this->getUser($profile);

        $form = $this->createForm(ProfileEditType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }
        return $this->render('user/profileEdit.html.twig', [
            'updateForm' => $form->createView()
        ]);
    }

}
