<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Activity;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\Profile;
use App\Entity\State;
use App\Entity\User;
use App\Form\ActivityType;
use App\Form\CommentType;
use App\Form\SearchType;
use App\Repository\ActivityRepository;
use App\Repository\StateRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{


    /**
     * Affiche la liste des activités
     * @Route("/", name="activity_index", methods={"GET"})
     */
    public function index(ActivityRepository $activityRepository, Request $request): Response

    {
        //Afficher les dix dernières activités

        $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
        $activities = $activityRepository->TopTenRecentActivitiesPublished();

        // Pour faire la recherche selon les catégories, date et titre

        $data = new SearchData();
        $form = $this ->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $activities = $activityRepository->findSearch($data);
        }


        return $this->render('activity/index.html.twig', [
            'activities' => $activities,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * Affiche le formulaire de création d'activité
     * @Route("/new", name="activity_new", methods={"GET","POST"})
     */
    public function new(Request $request, StateRepository $stateRepository): Response
    {
        $activity = new Activity();
        $user = $this->getUser(); //recuperer l'utilisateur connecté
        $activity->setUser($user); //affecte à la creation d'activité
        $state = $stateRepository->findOneBy(array('id'=> 4)); // la valeur de l'état en base selon son id
        $activity->setState($state);  //etat de l'activité une fois créée

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Pour recuperer les pictures transmises
            $pictures = $form->get('pictures')->getData();
            //on boucle sur la picture
            foreach ($pictures as $picture) {
                $fichier = md5(uniqid()) . '.' . $picture->guessExtension(); // on genere un nom de fichier pour eviter des noms dupliqués
                // On copie le fichier dans le dossier uploads
                $picture->move(
                    $this->getParameter('pictures_directory'), $fichier
                );
                // On crée l'image dans la base de données: stocker
                $img = new Picture();
                $img->setFilename($fichier);
                $activity->addPicture($img);

            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            $this->addFlash('success', 'Votre activité a été bien créée et en attente de validation !');
            return $this->redirectToRoute('activity_index');
        }

        return $this->render('activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_show", methods={"GET", "POST"})
     */
    public function show(Activity $activity, Request $request, UserRepository $userRepository): Response
    {
        //injecter la page des commentaires dans la visualisation des activités
        $comment = new Comment();
        $comment->setValidate(true);
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {

            $comment->setUser($this->getUser());//L'utilisateur du commentaire  est l'utilisateur  connecté
            $comment->setActivity($activity); //L'activité commenté  est celle que l'on affiche

            if($this->getUser() != null){
                $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
                // $activity = $activityRepository->find($id);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();

                return $this->redirectToRoute('activity_show', ['id' => $activity->getId()]);

                $formComment = $formComment->getData();
            }else{

                $this->addFlash('warning', 'Merci de bien vouloir se connecter pour poster un commentaire sur cette activité');
            }

        }

        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'formComment' => $formComment->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="activity_edit", methods={"GET" ,"POST"})
     */
    public function edit(Request $request, Activity $activity): Response
    {

        $form = $this->createForm(ActivityType::class, $activity);
        $activity->setUser($this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Pour recuperer les pictures transmises
            $pictures = $form->get('pictures')->getData();

            foreach ($pictures as $picture) {
                $fichier = md5(uniqid()) . '.' . $picture->guessExtension(); // on genere un nom de fichier pour eviter des noms dupliqués
                // On copie le fichier dans le dossier uploads
                $picture->move(
                    $this->getParameter('pictures_directory'), $fichier
                );
                // On crée l'image dans la base de données: stocker
                $img = new Picture();
                $img->setFilename($fichier);
                $activity->addPicture($img);

            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activity_index');
        }

        return $this->render('activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="activity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Activity $activity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('activity_index');
    }


    /**
     * Suppression des pictures
     * @Route("/delete/picture/{id}", name="activity_picture_delete", methods={"DELETE"})
     */
    public function deletePicture(Picture $picture, Request $request){
        $data = json_decode($request->getContent(), true);

        // On vérifie si le token est valide
        if($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])){
            // On récupère le nom de l'image
            $nom = $picture->getFilename();
            // On supprime le fichier
            unlink($this->getParameter('pictures_directory').'/'.$nom);

            // On supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($picture);
            $em->flush();

            // On répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}