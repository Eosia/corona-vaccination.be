<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {

        //gestion du form de contact
        $form = $this->createForm(ContactType::class, [
            'method'=>'GET',
            'csrf_protection' => false
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            //envoi du mail
            $message = (new \Swift_Message('Nouveau Message de'.' '.$contact['email']))

                // On attribue l'expéditeur
                ->setFrom($contact['email'])

                // On attribue le destinataire
                ->setTo('contact@corona-vaccination.be')

                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            $mailer->send($message);

            // Permet un message flash de renvoi
            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les plus brefs délais.');

            //reset le form de contact apres envoi du mail
            return $this->redirect($request->getUri());

        }
        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
}
