<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Comment;
use App\Entity\Picture;
use App\Entity\User;
use App\Form\ActivityType;
use App\Form\CommentType;
use App\Form\PictureType;
use App\Repository\ActivityRepository;
use App\Repository\CommentRepository;
use App\Repository\IconRepository;
use App\Repository\PictureRepository;
use App\Repository\ProfileRepository;
use App\Repository\StateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/activity")
 */

class ActivityController extends AbstractController
{

    /**
     * Affiche la liste des activites
     * @Route("", name="activity_index", methods={"GET"})
     */
    public function index(): Response
    {
        $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
        $activities = $activityRepository->TopTenRecentActivity(); //Liste des 10 recentes activités publiées
        //dump($activities);

        $this->redirectToRoute('app_index');

        return $this->render('activity/index.html.twig', [
            'activities' => $activities
        ]);
    }


    /**
     * Affiche une activité
     * @Route("/{id}", name="activity_show", methods={"GET", "POST"}, requirements={"id": "\d+"})

     */
    public function show(ActivityRepository $activityRepository, $id, Request $request, Activity $activity, EntityManagerInterface $em, CommentRepository $commentRepository): Response
    {


        //gestion du formulaire des commentaires
        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {

            $comment->setUser($this->getUser());//L'utilisateur du commentaire  est l'utilisateur  connecté
            $comment->setActivity($activity); //L'activité commenté  est celle que l'on affiche


            $activityRepository = $this->getDoctrine()->getRepository(Activity::class);
            $activity = $activityRepository->find($id);

            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('activity_show', ['id' => $activity->getId()]);

            $comment = $formComment->getData();

        }


        return $this->render('activity/show.html.twig', [
            'activity' => $activity,
            'comment' => $formComment->createView()
        ]);
    }

    /**
     * Afficher le formulaire de creation d'une activité
     * @Route("/new", name="activity_new", methods={"GET", "POST"})

     */
    public function new(Request $request, EntityManagerInterface $em, StateRepository $stateRepository): Response
    {
        $activity = new Activity();
        $user = $this->getUser();
        $activity->setUser($user); //on veut récuperer l'utilisateur connecté
        $state = $stateRepository->findOneBy(array('id' => '8'));  //on definie l'état de l'activté à la valeur En cours
        $activity->setState($state);

        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            //Pour recuperer les images transmises
            $pictures = $form->get('pictures')->getData();

            //on boucle sur les images
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

            $this->addFlash('success', 'Activité créée avec succès!');
            $em->persist($activity);
            $em->flush();
            return $this->redirectToRoute('activity_index');
        }

        return $this->render('activity/_form.html.twig', [
            'activity'=> $activity,
            'form' => $form->createView()

        ]);
    }


    /**
     * Affiche le formulaire d'édition d'une activité (GET)
     * Traite le formulaire d'édition d'une activité (POST)
     * @Route("/{id}/edit", name="activity_edit", methods={"GET", "POST"})
     */
    public function edit(Activity $activity, EntityManagerInterface $em, Request $request)
    {
        //$activity = $em->getRepository(Activity::class)->find($id);
        // $activity->setUser($this->getUser());
        //verifier si le user a le droit de modifier

        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            //Pour recuperer les images transmises
            $pictures = $form->get('pictures')->getData();

            //on boucle sur les images
            foreach ($pictures as $picture) {
                $fichier = md5(uniqid()) .'.'. $picture->guessExtension(); // on genere un nom de fichier pour eviter des noms dupliqués

                // On copie le fichier dans le dossier uploads
                $picture->move(
                    $this->getParameter('pictures_directory'), $fichier
                );
                // On crée l'image dans la base de données: stocker
                $img = new Picture();
                $img->setFilename($fichier);
                $activity->addPicture($img);

            }
            $em->flush();
            return $this->redirectToRoute('activity_index');

        }
        return $this->render('activity/edit.html.twig', [
            'activity' => $activity,
            'form'=> $form->createView()
        ]);
    }


    /**
     * Suppression d'activité
     * @Route("/{id}", name="activity_delete", methods={"DELETE"} )
     */
    public function delete(Activity $activity, Request $request, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            $em->remove($activity);
            $em->flush();
        }

        return $this->redirectToRoute('activity_index');
    }

    /**
     * Suppression des images
     * @Route("/delete/picture/{id}", name="activity-picture_delete", methods={"DELETE"})
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


