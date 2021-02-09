<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            //ContactType::HONEYPOT_FIELD=>$honeyPot = $form->getData();
            $form->getData(ContactType::HONEY_FIELDFIELD);
            if(!empty($honeyPot)){

                $contact = $form->getData();

                // On instancie le Mailer
                $email = (new Email())
                    //  On attribue l'expéditeur
                    ->from($contact['email'])
                    // On attribue le destinataire
                    ->to('stage.symfony2021@gmail.com')
                    // On crée le contenue du message avec la vue Twig
                    ->subject($contact['subject'])
                    ->html(
                        $this->renderView(
                            'emails/contact.html.twig', compact('contact')
                        ),
                        'text/html'
                    );

                // on envoie le message
                $mailer->send($email);
                $this->addFlash('success', 'Le message a bien été envoyé');
                return $this->redirectToRoute('app_index');
            }
            else{
                $this->addFlash('warning', 'Merci de bien vouloir utiliser un email correct !');
            }

        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
