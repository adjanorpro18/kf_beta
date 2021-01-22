<?php


namespace App\Controller;


use App\Entity\Profile;
use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UpdateUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class UserController
 * @Route("/user")
 */

class UserController extends AbstractController
{


    /**
     * @Route ("/{id}/profile", name="user_profile", requirements={"id": "\d+"}, methods={"GET"})
     * Afficher le profil de l'utilisateur
     */
    public function profile($id, UserRepository $userRepository)
    {

        $user = $userRepository->find($id);
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route ("/{id}/profile/edit", name="user_profile_edit", requirements={"id": "\d+"}, methods={"GET","POST"})
     *Modifier le profil de l'utilisateur
     */
    public function userProfileEdit(Request $request, $id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');
            return $this->redirectToRoute('user_profile', ['id' => $user->getId()]);
        }
        return $this->render('user/proflie_update.html.twig', [
            'updateForm' => $form->createView()
        ]);
    }
}
