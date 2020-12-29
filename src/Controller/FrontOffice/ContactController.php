<?php

namespace App\Controller\FrontOffice;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('verif')->getData() == 11) {
                $send_email = (new \Swift_Message('Teamates - Message de ' . $form->get("name")->getData()))
                    ->setFrom('association@teamates-gaming.com')
                    ->setTo('contact.informatique@ribegroupe.com')
                    ->setBody("Nom : " . $form->get("name")->getData() . "<br>Adresse Mail : " . $form->get("email")->getData() . "<br>Objet : " . $form->get("objet")->getData() . "<br>Message : <br><br>" . nl2br(stripslashes(strip_tags($form->get("message")->getData()))), 'text/html');

                $mailer->send($send_email);
                return $this->render('FrontOffice/contact.html.twig', ['form' => $form->createView(), 'valid' => "Votre message à bien été envoyé"]);
            }else{
                return $this->render('FrontOffice/contact.html.twig', ['form' => $form->createView(), 'error' => "Ce n'est pas le bon resultat"]);
            }
        }


        return $this->render('FrontOffice/contact.html.twig', ['form' => $form->createView()]);
    }

}
